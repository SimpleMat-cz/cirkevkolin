<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CoDelameController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('CoDelame/Index');
    }

    public function nedelniSetkani(): Response
    {
        return Inertia::render('CoDelame/NedelniSetkani');
    }

    public function kidztown(): Response
    {
        return Inertia::render('CoDelame/Kidztown');
    }

    public function wyldlife(): Response
    {
        return Inertia::render('CoDelame/Wyldlife');
    }

    public function skupinky(): Response
    {
        return Inertia::render('CoDelame/Skupinky');
    }

    public function youngLife(): Response
    {
        return Inertia::render('CoDelame/YoungLife');
    }

    public function kavarna(): Response
    {
        return Inertia::render('CoDelame/Kavarna');
    }

    public function business(): Response
    {
        return Inertia::render('CoDelame/Business');
    }
}
