<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        // Azioni Fortify standard
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        /*
        |--------------------------------------------------------------------------
        | Rate limiting
        |--------------------------------------------------------------------------
        */
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /*
        |--------------------------------------------------------------------------
        | Viste Fortify
        |--------------------------------------------------------------------------
        */

        // Login
        Fortify::loginView(fn() => view('auth.login'));

        // Registrazione: passiamo i ruoli alla view
        Fortify::registerView(function () {
            // Se NON vuoi che la gente possa auto-selezionare "Amministratore"
            $roles = Role::where('slug', '!=', 'amministratore')->get();

            return view('auth.register', [
                'roles' => $roles,
            ]);
        });

        // Password reset
        Fortify::requestPasswordResetLinkView(fn() => view('auth.forgot-password'));

        Fortify::resetPasswordView(
            fn($request) => view('auth.reset-password', ['request' => $request])
        );

        /*
        |--------------------------------------------------------------------------
        | Logica di autenticazione personalizzata
        | - Verifica email/password
        | - Permette l'accesso SOLO se l'utente è "attivo" (is_active = true)
        |--------------------------------------------------------------------------
        */
        Fortify::authenticateUsing(function (Request $request) {
            /** @var \App\Models\User|null $user */
            $user = User::where('email', $request->email)->first();

            if (! $user) {
                return null;
            }

            if (! Hash::check($request->password, $user->password)) {
                return null;
            }

            // Utente registrato ma NON ancora abilitato dall'amministratore
            if (! $user->is_active) {
                // Puoi anche personalizzare un messaggio via sessione se vuoi
                return null;
            }

            return $user;
        });
    }
}
