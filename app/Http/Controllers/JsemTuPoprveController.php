<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsemTuPoprveController extends Controller
{
    public function index(): \Inertia\Response
    {
        return \Inertia\Inertia::render('JsemTuPoprve');
    }
}
