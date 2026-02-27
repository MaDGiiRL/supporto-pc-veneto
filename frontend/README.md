# Frontend React/Vite - Supporto PC Veneto

Questa cartella contiene la **nuova base progetto Vite + React** per sostituire progressivamente l'intero layer Blade.

## Copertura funzionale migrata (strutturale)

La migrazione copre tutte le aree presenti in views/controller del progetto Laravel:

- Home (`HomeController`, `resources/views/home.blade.php`)
- Auth (`login`, `register`, `forgot/reset password`)
- Cartografie (`CartografieController`)
- Percezione sismica (`PercezioneSismicaController`)
- Applicativi (`ApplicativiController`)
- Segnalazioni SOR (`SegnalazioniController`, `Sor/*Controller`, sezioni dashboard/sinottico/coordinamento/eventi/log/...)
- Formazione (`FormazioneController`, sezioni corsi/iscrizioni/presenze/libretto/export/...)
- Admin utenti (`Admin/UserApprovalController`)
- Error page 403

## Struttura

- `src/app/App.jsx`: router principale con tutte le route applicative.
- `src/pages/**`: pagine React per tutti i moduli.
- `src/services/api.js`: layer API centralizzato coerente con i controller backend.
- `src/config/endpoints.js`: mappa endpoint Laravel API.

## Esecuzione

```bash
cd frontend
npm install
npm run dev
```

> Nota ambiente corrente: l'accesso ai registry npm può essere bloccato. In tal caso eseguire gli stessi comandi in ambiente CI/dev con accesso al registry interno aziendale.

## Strategia di integrazione backend

1. Esporre endpoint JSON per ogni sezione (se non già presenti).
2. Collegare autenticazione (Sanctum/session cookie).
3. Disattivare progressivamente le Blade route, mantenendo fallback durante il cutover.
