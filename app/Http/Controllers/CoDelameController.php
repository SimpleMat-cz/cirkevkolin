<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoDelameController extends Controller
{
    public function index(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/Index');
    }

    public function nedelniSetkani(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/NedelniSetkani');
    }

    public function kidztown(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/Kidztown');
    }

    public function wyldlife(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/Wyldlife');
    }

    public function skupinky(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/Skupinky');
    }

    public function youngLife(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/YoungLife');
    }

    public function kavarna(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/Kavarna');
    }

    public function business(): \Inertia\Response
    {
        return \Inertia\Inertia::render('CoDelame/Business');
    }
}
