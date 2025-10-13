<?php

// Mappo i nomi delle icone Lucide -> Heroicons v2 (outline) usate in Blade:
// LayoutDashboard -> squares-2x2
// Activity         -> chart-bar
// BadgeInfo        -> information-circle
// Search           -> magnifying-glass
// FileText         -> document-text
// Flame            -> fire
// Map              -> map
// Phone            -> phone
// History          -> clock
// Database         -> circle-stack
// MapPin           -> map-pin
// Layers3          -> squares-plus
// MapPinned        -> map-pin
// Users            -> users
// BarChart3        -> chart-bar
// ClipboardList    -> clipboard-document-list
// Table            -> table-cells

return [
    'routes' => [
        // GENERALE
        ['label' => 'Dashboard',                 'path' => 'dashboard',                 'icon' => 'squares-2x2',               'category' => 'Generale'],
        ['label' => 'Sinottico',                 'path' => 'sinottico',                 'icon' => 'chart-bar',                 'category' => 'Generale'],
        ['label' => 'Apertura/chiusura SOR',     'path' => 'apertura-chiusura-sor',     'icon' => 'information-circle',        'category' => 'Generale'],
        ['label' => 'Ricerca',                   'path' => 'ricerca',                   'icon' => 'magnifying-glass',          'category' => 'Generale'],
        // ['label' => 'Segnalazione generica',     'path' => 'segnalazione-generica',     'icon' => 'document-text',             'category' => 'Generale'],
        // ['label' => 'Eventi AIB',                'path' => 'eventi-aib',                'icon' => 'fire',                      'category' => 'Generale'],
        ['label' => 'Monitoraggio COC',          'path' => 'monitoraggio-coc',          'icon' => 'map',                       'category' => 'Generale'],
        // ['label' => 'Telefonata reperibilità',   'path' => 'telefonata-rep',            'icon' => 'phone',                     'category' => 'Generale'],
        ['label' => 'Tabella riassuntiva',       'path' => 'tabella-riassuntiva',       'icon' => 'table-cells',               'category' => 'Generale'],
        // ['label' => 'Eventi in atto',            'path' => 'eventi-in-atto',            'icon' => 'activity', /* alt: chart-bar */ 'category' => 'Generale'],

        // STORICO
        ['label' => 'Storico Chiamate',          'path' => 'storico-chiamate',          'icon' => 'phone',                     'category' => 'Storico'],
        ['label' => 'Storico VVF Estrazione',    'path' => 'storico-vvf-estrazione',    'icon' => 'clock',                     'category' => 'Storico'],
        ['label' => 'Storico VVF Mappatura',     'path' => 'storico-vvf-mappatura',     'icon' => 'circle-stack',              'category' => 'Storico'],

        // EMERGENZE
        ['label' => 'Emergency scenarios',       'path' => 'emergency-scenarios',       'icon' => 'squares-plus',              'category' => 'Emergenze'],
        ['label' => 'Emergency Management',      'path' => 'emergency-management',      'icon' => 'clipboard-document-list',   'category' => 'Emergenze'],

        // MAPPE
        ['label' => 'Mappa eventi',              'path' => 'mappa-eventi',              'icon' => 'map-pin',                   'category' => 'Mappe'],
        ['label' => 'Mappa Interventi VVF',      'path' => 'mappa-interventi-vvf',      'icon' => 'map-pin',                   'category' => 'Mappe'],
        ['label' => 'Mappa cluster eventi VVF',  'path' => 'mappa-cluster-vvf',         'icon' => 'squares-plus',              'category' => 'Mappe'],
        ['label' => 'Mappa stato COC',           'path' => 'mappa-stato-coc',           'icon' => 'map',                       'category' => 'Mappe'],
        ['label' => 'Mappa att.tà organizzazioni', 'path' => 'mappa-attivita-organizzazioni', 'icon' => 'users',                  'category' => 'Mappe'],

        // ALTRE
        ['label' => 'Ricerca recapiti',          'path' => 'ricerca-recapiti',          'icon' => 'magnifying-glass',          'category' => 'Generale'],
        ['label' => 'Reportistica',              'path' => 'reportistica',              'icon' => 'chart-bar',                 'category' => 'Generale'],
    ],
];
