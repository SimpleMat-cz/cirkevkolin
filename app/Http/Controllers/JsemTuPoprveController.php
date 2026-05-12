<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use Inertia\Inertia;
use Inertia\Response;

class JsemTuPoprveController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('JsemTuPoprve', [
            'page' => Page::findBySlug('jsem-tu-poprve'),
            'faqs' => Faq::query()
                ->published()
                ->forPage('jsem-tu-poprve')
                ->orderBy('sort')
                ->get(['id', 'question', 'answer']),
        ]);
    }
}
