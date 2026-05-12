<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class KdoJsmeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('KdoJsme', [
            'page' => Page::findBySlug('kdo-jsme'),
        ]);
    }
}
