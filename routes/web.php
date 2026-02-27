<?php

use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\ApplicativiController;
use App\Http\Controllers\Coc\CocController;
use App\Http\Controllers\FormazioneController;
use App\Http\Controllers\SegnalazioniController;
use App\Http\Controllers\Sor\ComunicazioniController;
use App\Http\Controllers\Sor\CoordinamentoController;
use App\Http\Controllers\Sor\EventoController;
use App\Http\Controllers\Sor\SegnalazioneController;
use App\Http\Controllers\SorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home pubblica
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| Rotte protette (pagine Blade)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::view('/cartografie', 'cartografie.index')->name('cartografie.index');
    Route::view('/percezione', 'percezione.index')->name('percezione.index');

    /*
    |--------------------------------------------------------------------------
    | Applicativi
    |--------------------------------------------------------------------------
    */
    Route::prefix('applicativi')->name('applicativi.')->group(function () {
        Route::get('/', [ApplicativiController::class, 'index'])->name('index');
        Route::get('{slug}', [ApplicativiController::class, 'show'])->name('show');
    });

    /*
    |--------------------------------------------------------------------------
    | Segnalazioni (pagine Blade)
    |--------------------------------------------------------------------------
    */
    Route::redirect('/segnalazioni', '/segnalazioni/dashboard')->name('segnalazioni.index');

    // Pagina LOG dentro lo stesso layout Segnalazioni
    Route::get('/segnalazioni/log', [SegnalazioniController::class, 'show'])
        ->defaults('page', 'log')
        ->name('segnalazioni.logs');

    // Alias /segnalazioni/logs → redirect a /segnalazioni/log (opzionale)
    Route::get('/segnalazioni/logs', fn() => redirect()->route('segnalazioni.logs'));

    // Tutte le altre sezioni (dashboard, coordinamento, ecc.)
    Route::get('/segnalazioni/{page?}', [SegnalazioniController::class, 'show'])
        ->where('page', '[A-Za-z0-9\-\_]+')
        ->name('segnalazioni.section');

    /*
    |--------------------------------------------------------------------------
    | Formazione (pagine Blade) ✅ FUORI da /api/sor
    |--------------------------------------------------------------------------
    */
    Route::redirect('/formazione', '/formazione/corsi')->name('formazione.index');

    Route::get('/formazione/{page?}', [FormazioneController::class, 'show'])
        ->where('page', '[A-Za-z0-9\-\_]+')
        ->name('formazione.section');

    /*
    |--------------------------------------------------------------------------
    | API interne per salvataggio stato SOR / COC (POST dal front)
    |--------------------------------------------------------------------------
    */
    Route::post('/sor', [SorController::class, 'update'])->name('sor.update');

    Route::post('/coc', [CocController::class, 'update'])->name('coc.update');

    /*
    |--------------------------------------------------------------------------
    | Pannello Amministratore (solo utenti con is_admin = true)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserApprovalController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserApprovalController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserApprovalController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/approve', [UserApprovalController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/deactivate', [UserApprovalController::class, 'deactivate'])->name('users.deactivate');
    });
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()
        ->route('home')
        ->with('alert', [
            'type'    => 'success',
            'title'   => 'Logout effettuato',
            'message' => 'Hai effettuato l’uscita correttamente.',
        ]);
})->name('logout');

/*
|--------------------------------------------------------------------------
| Ping pubblico (facoltativo)
|--------------------------------------------------------------------------
*/
Route::get('/api/ping', fn() => response()->json(['ok' => true]));

/*
|--------------------------------------------------------------------------
| API SOR PUBBLICHE (se servono anche fuori dashboard)
|--------------------------------------------------------------------------
*/
Route::prefix('sor')->group(function () {
    Route::get('roles',                       [CoordinamentoController::class, 'roles']);
    Route::get('segnalazioni',                [CoordinamentoController::class, 'listSegnalazioni']); // con filtri status/assigned_to
    Route::patch('segnalazioni/{id}/assign',  [CoordinamentoController::class, 'assign']);
    Route::patch('segnalazioni/{id}/close',   [CoordinamentoController::class, 'close']);
    Route::post('segnalazioni/{id}/notes',    [CoordinamentoController::class, 'addNote']);
    Route::get('logs',                        [CoordinamentoController::class, 'logs']); // log coordinamento (pubblici)
});

/*
|--------------------------------------------------------------------------
| API SOR PROTETTE (dashboard chiama: /api/sor/…)
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth'])->prefix('api/sor')->group(function () {

    // Segnalazioni generiche (CRUD + export)
    Route::get('segnalazioni',                    [SegnalazioneController::class, 'index']);
    Route::post('segnalazioni',                   [SegnalazioneController::class, 'store']);
    Route::patch('segnalazioni/{segnalazione}',   [SegnalazioneController::class, 'update']);
    Route::delete('segnalazioni/{segnalazione}',  [SegnalazioneController::class, 'destroy']);
    Route::get('segnalazioni/export.csv',         [SegnalazioneController::class, 'export']);

    // Eventi (lista/dettaglio/toggle + comunicazioni nested + export)
    Route::get('eventi',                               [EventoController::class, 'index']);
    Route::get('eventi/{evento}',                      [EventoController::class, 'show']);
    Route::post('eventi',                              [EventoController::class, 'store']);
    Route::patch('eventi/{evento}/toggle',             [EventoController::class, 'toggle']);
    Route::post('eventi/{evento}/comunicazioni',       [ComunicazioniController::class, 'store']);
    Route::patch('eventi/{evento}/comunicazioni/{id}', [ComunicazioniController::class, 'update']);
    Route::delete('eventi/{evento}/comunicazioni/{id}', [ComunicazioniController::class, 'destroy']);
    Route::get('eventi/export.csv',                    [EventoController::class, 'export']);
    Route::get('eventi/{id}/export.csv',               [EventoController::class, 'exportSingle']);

    // Coordinamento / Ops (ruoli, assegnazioni, chiusure, note, logs coordinamento)
    Route::get('roles',                        [CoordinamentoController::class, 'roles']);
    Route::get('segnalazioni-coord',           [CoordinamentoController::class, 'listSegnalazioni']); // alias
    Route::patch('segnalazioni/{id}/assign',   [CoordinamentoController::class, 'assign']);
    Route::patch('segnalazioni/{id}/close',    [CoordinamentoController::class, 'close']);
    Route::post('segnalazioni/{id}/notes',     [CoordinamentoController::class, 'addNote']);
    Route::get('logs',                         [CoordinamentoController::class, 'logs']); // log coordinamento (admin)

    // chi sono: restituisce il ruolo SOR effettivo per il JS (usato dal Coordinamento)
    Route::get('me', function () {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (! $user) {
            return response()->json(['role' => null], 401);
        }

        return response()->json([
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $user->sorCoordRole(), // coordinamento | mezzi | volontariato | prociv
            'can_assign' => $user->canAssign(),
            'can_close'  => $user->canClose(),
        ]);
    });
});
