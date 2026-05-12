<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class NedeleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Nedele', [
            'page' => Page::findBySlug('nedele'),
        ]);
    }
}
