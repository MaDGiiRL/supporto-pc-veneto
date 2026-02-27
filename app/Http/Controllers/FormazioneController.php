<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FormazioneController extends Controller
{
    protected function pages(): array
    {
        return [
            // CATEGORIA: Corsi
            'corsi' => [
                'label' => 'Tutti i corsi',
                'icon' => 'academic-cap',
                'category' => 'Corsi',
            ],
            'corsi-in-corso' => [
                'label' => 'In corso',
                'icon' => 'play-circle',
                'category' => 'Corsi',
            ],
            'corsi-terminati' => [
                'label' => 'Terminati',
                'icon' => 'check-circle',
                'category' => 'Corsi',
            ],

            // CATEGORIA: Persone
            'studenti' => [
                'label' => 'Studenti',
                'icon' => 'user-group',
                'category' => 'Persone',
            ],
            'iscrizioni' => [
                'label' => 'Iscrizioni',
                'icon' => 'clipboard-document-check',
                'category' => 'Persone',
            ],
            'presenze' => [
                'label' => 'Registro presenze',
                'icon' => 'clock',
                'category' => 'Persone',
            ],

            // CATEGORIA: Strumenti
            'distanze' => [
                'label' => 'Distanze',
                'icon' => 'map',
                'category' => 'Strumenti',
            ],
            'export' => [
                'label' => 'Export',
                'icon' => 'arrow-down-tray',
                'category' => 'Strumenti',
            ],
            'libretto' => [
                'label' => 'Libretto formativo',
                'icon' => 'book-open',
                'category' => 'Strumenti',
            ],

            // CATEGORIA: Controlli
            'eccezioni-attestati' => [
                'label' => 'Eccezioni attestati',
                'icon' => 'exclamation-triangle',
                'category' => 'Controlli',
            ],
        ];
    }

    public function show(?string $page = 'corsi')
    {
        // usa la lista completa definita in pages()
        $pages = $this->pages();

        // aggiungi slug (utile per view e debug)
        foreach ($pages as $slug => &$cfg) {
            $cfg['slug'] = $slug;
        }
        unset($cfg);

        $currentKey = $page ?: 'corsi';

        // se slug non esiste, fallback a corsi
        if (!isset($pages[$currentKey])) {
            $currentKey = 'corsi';
        }

        $current = $pages[$currentKey];

        return view('applicativi.formazione.index', [
            'pages' => $pages,
            'currentKey' => $currentKey,
            'current' => $current,
            'canManageCourses' => true,
            'canEditPresenze' => true,
        ]);
    }
}
