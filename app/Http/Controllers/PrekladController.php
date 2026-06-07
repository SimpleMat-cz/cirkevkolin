<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PrekladController extends Controller
{
    public function viewer(): Response
    {
        return Inertia::render('Preklad/Viewer');
    }

    public function admin(): Response
    {
        return Inertia::render('Preklad/Admin');
    }
}
