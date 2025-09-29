<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ApplicativiController extends Controller
{
    public function index()
    {
        $apps = config('applicativi.items', []);
        return view('applicativi.index', compact('apps'));
    }

    public function show(string $slug)
    {
        $apps = config('applicativi.items', []);
        $app  = Arr::first($apps, fn($a) => $a['slug'] === $slug);

        abort_if(!$app, 404);
        return view('applicativi.show', compact('app'));
    }
}
