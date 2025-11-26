<?php

namespace App\Providers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | LOG AUTOMATICO DI TUTTE LE QUERY DI SCRITTURA
        |--------------------------------------------------------------------------
        */
        DB::listen(function ($query) {
            // Evita di loggare durante comandi artisan (migrate, db:seed, ecc.)
            if (app()->runningInConsole()) {
                return;
            }

            $sqlLower = strtolower($query->sql);

            // Consideriamo solo INSERT / UPDATE / DELETE
            if (! Str::startsWith($sqlLower, ['insert', 'update', 'delete'])) {
                return;
            }

            // Evita loop sui log stessi
            if (str_contains($sqlLower, 'activity_logs')) {
                return;
            }

            // Determina l'azione
            $action = 'db.query';
            if (Str::startsWith($sqlLower, 'insert')) {
                $action = 'db.insert';
            } elseif (Str::startsWith($sqlLower, 'update')) {
                $action = 'db.update';
            } elseif (Str::startsWith($sqlLower, 'delete')) {
                $action = 'db.delete';
            }

            // SQL + bindings in chiaro
            $description = $query->sql;

            if (! empty($query->bindings)) {
                $bindings = json_encode($query->bindings, JSON_UNESCAPED_UNICODE);
                $description .= ' | bindings: ' . $bindings;
            }

            // Info request (se esiste)
            $request   = request();
            $ip        = $request ? $request->ip() : null;
            $userAgent = $request ? $request->userAgent() : null;

            ActivityLog::create([
                'user_id'      => auth()->id(),
                'action'       => $action,
                'description'  => $description,
                'subject_type' => null,
                'subject_id'   => null,
                'ip_address'   => $ip,
                'user_agent'   => $userAgent,
                'created_at'   => now(),
            ]);
        });
    }
}
