<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequestRequest;
use App\Models\VisitRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class VisitRequestController extends Controller
{
    public function store(StoreVisitRequestRequest $request): RedirectResponse
    {
        $visitRequest = VisitRequest::create($request->validated());

        Mail::raw(
            "Nová přihláška návštěvy:\n\n"
            . "Jméno: {$visitRequest->name}\n"
            . "E-mail: {$visitRequest->email}\n"
            . "Telefon: {$visitRequest->phone}\n"
            . "Počet lidí: {$visitRequest->people_count}\n"
            . "Datum: {$visitRequest->planned_visit_date}\n"
            . "Poznámka: {$visitRequest->note}",
            fn ($message) => $message
                ->to(config('mail.admin_address', 'kolin@apostolskacirkev.cz'))
                ->subject("Nová přihláška návštěvy — {$visitRequest->name}")
        );

        return back()->with('success', 'Díky! Brzy se ozveme.');
    }
}
