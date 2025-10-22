<?php

use App\Http\Controllers\ApplicativiController;
use App\Http\Controllers\SegnalazioniController;
use App\Http\Controllers\Sor\EventoController;
use App\Http\Controllers\Sor\SegnalazioneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::view('/', 'home')->name('home');

// Rotte protette
Route::middleware('auth')->group(function () {
    Route::view('/cartografie', 'cartografie.index')->name('cartografie.index');
    Route::view('/percezione', 'percezione.index')->name('percezione.index');

    // Applicativi (unica definizione, senza duplicati)
    Route::prefix('applicativi')->name('applicativi.')->group(function () {
        Route::get('/', [ApplicativiController::class, 'index'])->name('index');
        Route::get('{slug}', [ApplicativiController::class, 'show'])->name('show');
    });
});

// Segnalazioni
Route::redirect('/segnalazioni', '/segnalazioni/dashboard')->name('segnalazioni.index');
Route::get('/segnalazioni/{page?}', [SegnalazioniController::class, 'show'])
    ->where('page', '[A-Za-z0-9\-\_]+')
    ->name('segnalazioni.section');


Route::post('/logout', function (Request $request) {
    // Logout “pulito”
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Flash nel formato che la tua layout già usa
    return redirect()
        ->route('home')
        ->with('alert', [
            'type'    => 'success',
            'title'   => 'Logout effettuato',
            'message' => 'Hai effettuato l’uscita correttamente.'
        ]);
})->name('logout');


// Ping di test (pubblico, opzionale)
Route::get('/api/ping', fn() => response()->json(['ok' => true]));

// Rotte SOR protette da sessione Fortify
Route::middleware(['web', 'auth'])
    ->prefix('api/sor')
    ->group(function () {

        // Segnalazioni generiche
        Route::get('segnalazioni',                    [SegnalazioneController::class, 'index']);
        Route::post('segnalazioni',                   [SegnalazioneController::class, 'store']);
        Route::patch('segnalazioni/{segnalazione}',   [SegnalazioneController::class, 'update']);
        Route::delete('segnalazioni/{segnalazione}',  [SegnalazioneController::class, 'destroy']);
        Route::get('segnalazioni/export.csv',         [SegnalazioneController::class, 'export']);

        // Eventi
        Route::get('eventi',                          [EventoController::class, 'index']);
        Route::get('eventi/{evento}',                 [EventoController::class, 'show']);
        Route::post('eventi',                         [EventoController::class, 'store']);
        Route::patch('eventi/{evento}/toggle',        [EventoController::class, 'toggle']);
        Route::post('eventi/{evento}/comunicazioni',  [EventoController::class, 'addComunicazione']);
        Route::get('eventi/export.csv',               [EventoController::class, 'export']);

        // (opzionale) chi sono
        Route::get('me', fn() => auth()->user());
    });
