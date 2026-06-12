<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequestRequest;
use App\Models\VisitRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VisitRequestController extends Controller
{
    public function store(StoreVisitRequestRequest $request): RedirectResponse
    {
        $visitRequest = VisitRequest::create($request->safe()->except('website'));

        // E-mail je jen notifikace — přihláška je uložená v databázi a viditelná
        // v administraci, takže výpadek SMTP nesmí rozbít odeslání formuláře.
        rescue(fn () => Mail::raw(
            "Nová přihláška návštěvy:\n\n"
            ."Jméno: {$visitRequest->name}\n"
            ."E-mail: {$visitRequest->email}\n"
            ."Telefon: {$visitRequest->phone}\n"
            ."Počet lidí: {$visitRequest->people_count}\n"
            ."Datum: {$visitRequest->planned_visit_date}\n"
            ."Poznámka: {$visitRequest->note}",
            fn ($message) => $message
                ->to(config('mail.admin_address', 'kolin@apostolskacirkev.cz'))
                ->subject('Nová přihláška návštěvy — '.Str::squish($visitRequest->name))
        ));

        return back()->with('success', 'Díky! Brzy se ozveme.');
    }
}
