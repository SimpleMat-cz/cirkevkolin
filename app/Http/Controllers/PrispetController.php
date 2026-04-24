<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class PrispetController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Prispet', [
            'iban' => 'CZ6508000000004356693790',
            'accountNumber' => '435669379/0800',
        ]);
    }
}
