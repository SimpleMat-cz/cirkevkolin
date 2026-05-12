<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class KontaktController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Kontakt', [
            'page' => Page::findBySlug('kontakt'),
        ]);
    }
}
