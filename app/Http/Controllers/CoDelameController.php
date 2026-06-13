<?php

namespace App\Http\Controllers;

use App\Models\Leader;
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
        return $this->activityPage('CoDelame/NedelniSetkani', 'nedelni-setkani');
    }

    public function kidztown(): Response
    {
        return $this->activityPage('CoDelame/Kidztown', 'kidztown');
    }

    public function wyldlife(): Response
    {
        return $this->activityPage('CoDelame/Wyldlife', 'wyldlife');
    }

    public function skupinky(): Response
    {
        return $this->activityPage('CoDelame/Skupinky', 'skupinky');
    }

    public function youngLife(): Response
    {
        return $this->activityPage('CoDelame/YoungLife', 'young-life');
    }

    public function kavarna(): Response
    {
        return $this->activityPage('CoDelame/Kavarna', 'kavarna');
    }

    public function business(): Response
    {
        return $this->activityPage('CoDelame/Business', 'business');
    }

    private function activityPage(string $component, string $pageSlug): Response
    {
        return Inertia::render($component, [
            'leaders' => $this->leadersFor($pageSlug),
        ]);
    }

    /**
     * Vedoucí spravovaní v administraci. Prázdné pole = stránka použije
     * svůj původní statický seznam, dokud se data nedoplní.
     *
     * @return list<array{name: string, role: ?string, phone: ?string, email: ?string, photo: ?string}>
     */
    private function leadersFor(string $pageSlug): array
    {
        return Leader::query()
            ->forPage($pageSlug)
            ->get()
            ->map(fn (Leader $leader): array => [
                'name' => $leader->name,
                'role' => $leader->role,
                'phone' => $leader->phone,
                'email' => $leader->email,
                'photo' => $leader->photo_url,
            ])
            ->values()
            ->all();
    }
}
