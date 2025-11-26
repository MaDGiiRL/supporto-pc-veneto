<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserApprovalController extends Controller
{
    public function index(Request $request)
    {
        // tab attiva: pending | all | logs
        $tab = $request->get('tab', 'pending');

        // statistiche globali
        $totalUsers   = User::count();
        $totalActive  = User::where('is_active', true)->count();
        $totalPending = User::where('is_active', false)->count();
        $totalLogs    = ActivityLog::count();

        $users = null;
        $logs  = null;

        if ($tab === 'all') {
            $users = User::with('roles')
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString();
        } elseif ($tab === 'logs') {
            // --- FILTRI LOG ---
            $filterAction = $request->get('log_action');   // create, update, delete, approve, ...
            $filterUser   = $request->get('log_user');     // nome / email
            $filterText   = $request->get('log_q');        // descrizione
            $filterFrom   = $request->get('log_from');     // data da
            $filterTo     = $request->get('log_to');       // data a

            $logsQuery = ActivityLog::with('user');

            // Filtro azione "semplificata"
            if ($filterAction && $filterAction !== 'all') {
                $logsQuery->where(function ($q) use ($filterAction) {
                    switch ($filterAction) {
                        case 'create':
                            $q->where('action', 'create')
                                ->orWhere('action', 'like', '%.create')
                                ->orWhere('action', 'like', 'db.insert%');
                            break;
                        case 'update':
                            $q->where('action', 'update')
                                ->orWhere('action', 'like', '%.update')
                                ->orWhere('action', 'like', 'db.update%');
                            break;
                        case 'delete':
                            $q->where('action', 'delete')
                                ->orWhere('action', 'like', '%.delete')
                                ->orWhere('action', 'like', 'db.delete%');
                            break;
                        case 'approve':
                            $q->where('action', 'like', '%approve%');
                            break;
                        case 'deactivate':
                            $q->where('action', 'like', '%deactivate%');
                            break;
                        case 'assign':
                            $q->where('action', 'like', '%assign%');
                            break;
                        case 'close':
                            $q->where('action', 'like', '%close%');
                            break;
                        case 'other':
                            // tutto il resto (negazione dei principali)
                            $q->whereNot(function ($w) {
                                $w->where('action', 'like', 'db.insert%')
                                    ->orWhere('action', 'like', 'db.update%')
                                    ->orWhere('action', 'like', 'db.delete%')
                                    ->orWhere('action', 'like', '%create%')
                                    ->orWhere('action', 'like', '%update%')
                                    ->orWhere('action', 'like', '%delete%')
                                    ->orWhere('action', 'like', '%approve%')
                                    ->orWhere('action', 'like', '%deactivate%')
                                    ->orWhere('action', 'like', '%assign%')
                                    ->orWhere('action', 'like', '%close%');
                            });
                            break;
                    }
                });
            }

            // Filtro utente (nome o email parziale)
            if ($filterUser) {
                $logsQuery->whereHas('user', function ($uq) use ($filterUser) {
                    $term = '%' . $filterUser . '%';
                    $uq->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            }

            // Filtro testo descrizione
            if ($filterText) {
                $logsQuery->where('description', 'like', '%' . $filterText . '%');
            }

            // Filtri intervallo date (created_at)
            if ($filterFrom) {
                $logsQuery->whereDate('created_at', '>=', $filterFrom);
            }
            if ($filterTo) {
                $logsQuery->whereDate('created_at', '<=', $filterTo);
            }

            $logs = $logsQuery
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString();
        } else {
            // default: pending
            $tab = 'pending';
            $users = User::with('roles')
                ->where('is_active', false)
                ->orderBy('created_at', 'desc')
                ->paginate(20)
                ->withQueryString();
        }

        return view('admin.users.index', [
            'tab'          => $tab,
            'users'        => $users,
            'logs'         => $logs,
            'totalUsers'   => $totalUsers,
            'totalActive'  => $totalActive,
            'totalPending' => $totalPending,
            'totalLogs'    => $totalLogs,

            // valori correnti dei filtri (per riempire i campi nella view)
            'filterAction' => $filterAction ?? 'all',
            'filterUser'   => $filterUser   ?? '',
            'filterText'   => $filterText   ?? '',
            'filterFrom'   => $filterFrom   ?? '',
            'filterTo'     => $filterTo     ?? '',
        ]);
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('label')->get();
        $userRoleSlugs = $user->roles->pluck('slug')->all();

        return view('admin.users.edit', [
            'user'          => $user,
            'roles'         => $roles,
            'userRoleSlugs' => $userRoleSlugs,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name'   => ['required', 'string', 'max:100'],
            'last_name'    => ['required', 'string', 'max:100'],
            'organization' => ['required', 'string', 'max:150'],
            'phone'        => ['nullable', 'string', 'max:30'],

            'email'        => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user->id),
            ],

            'roles'        => ['required', 'array', 'min:1'],
            'roles.*'      => ['string', 'exists:roles,slug'],

            'is_active'    => ['nullable', 'boolean'],
        ]);

        $beforeActive = $user->is_active;

        $user->update([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'organization' => $validated['organization'],
            'phone'        => $validated['phone'] ?? null,
            'email'        => strtolower($validated['email']),
            'name'         => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'is_active'    => $request->boolean('is_active'),
        ]);

        $roleIds = Role::whereIn('slug', $validated['roles'])
            ->pluck('id')
            ->all();

        $user->roles()->sync($roleIds);

        ActivityLog::create([
            'user_id'      => auth()->id(),
            'action'       => 'user.update',
            'description'  => sprintf(
                'Aggiorno utente %s (%s). Attivo: %s → %s',
                $user->name,
                $user->email,
                $beforeActive ? 'sì' : 'no',
                $user->is_active ? 'sì' : 'no'
            ),
            'subject_type' => User::class,
            'subject_id'   => $user->id,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'created_at'   => now(),
        ]);

        return redirect()
            ->route('admin.users.index', ['tab' => 'all'])
            ->with('status', 'Utente aggiornato correttamente.');
    }

    public function approve(User $user, Request $request)
    {
        $user->update(['is_active' => true]);

        ActivityLog::create([
            'user_id'      => auth()->id(),
            'action'       => 'user.approve',
            'description'  => "Abilito utente {$user->name} ({$user->email})",
            'subject_type' => User::class,
            'subject_id'   => $user->id,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'created_at'   => now(),
        ]);

        return redirect()
            ->back()
            ->with('status', 'Utente abilitato correttamente.');
    }

    public function deactivate(User $user, Request $request)
    {
        $user->update(['is_active' => false]);

        ActivityLog::create([
            'user_id'      => auth()->id(),
            'action'       => 'user.deactivate',
            'description'  => "Disabilito utente {$user->name} ({$user->email})",
            'subject_type' => User::class,
            'subject_id'   => $user->id,
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'created_at'   => now(),
        ]);

        return redirect()
            ->back()
            ->with('status', 'Utente disabilitato.');
    }
}
