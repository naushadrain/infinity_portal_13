<?php

namespace App\Http\Controllers;

use App\Models\AbcParticipantDetail;
use App\Models\IncidentDetail;
use App\Models\Medication;
use App\Models\ReporterDetail;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id === 2) {
            return redirect()->route('forms.incident.index');
        }

        $recentUsers = User::with('role')->latest()->take(6)->get();

        $totalUsers        = User::whereIn('role_id', [2, 3])->count();
        $fromIncidentsCount = IncidentDetail::count();
        $newUsersCount     = User::whereIn('role_id', [2, 3])
            ->where('created_at', '>=', now()->subWeek())
            ->count();

        // Donut chart counts (last 30 days)
        $incidentCount   = ReporterDetail::where('created_at', '>=', now()->subDays(30))->count();
        $medicationCount = Medication::where('created_at', '>=', now()->subDays(30))->count();
        $abcChartCount   = AbcParticipantDetail::where('created_at', '>=', now()->subDays(30))->count();
        $otherCount      = 0;

        $formsTotal = $incidentCount + $medicationCount + $abcChartCount + $otherCount;

        $incidentPercent   = $formsTotal > 0 ? round(($incidentCount / $formsTotal) * 100) : 0;
        $medicationPercent = $formsTotal > 0 ? round(($medicationCount / $formsTotal) * 100) : 0;
        $abcChartPercent   = $formsTotal > 0 ? round(($abcChartCount / $formsTotal) * 100) : 0;
        $otherPercent      = $formsTotal > 0 ? round(($otherCount / $formsTotal) * 100) : 0;

        // Latest submissions – merge all 3 form types, sorted by created_at desc, take 10
        $latestSubmissions = collect();

        ReporterDetail::latest()->take(5)->get()->each(function ($item) use ($latestSubmissions) {
            $latestSubmissions->push([
                'ref'  => $item->ir_number ? '#' . $item->ir_number : '#INC-' . $item->id,
                'type' => 'Incident',
                'name' => $item->name,
                'city' => $item->city ?? '—',
                'when' => $item->created_at,
            ]);
        });

        Medication::latest()->take(5)->get()->each(function ($item) use ($latestSubmissions) {
            $latestSubmissions->push([
                'ref'  => '#MED-' . $item->id,
                'type' => 'Medication',
                'name' => $item->pr_name,
                'city' => $item->cd_location ?? '—',
                'when' => $item->created_at,
            ]);
        });

        AbcParticipantDetail::latest()->take(5)->get()->each(function ($item) use ($latestSubmissions) {
            $latestSubmissions->push([
                'ref'  => '#ABC-' . $item->id,
                'type' => 'ABC Chart',
                'name' => $item->participant_name,
                'city' => '—',
                'when' => $item->created_at,
            ]);
        });

        $latestSubmissions = $latestSubmissions
            ->sortByDesc('when')
            ->take(10)
            ->values();

        return view('pages.dashboard', compact(
            'recentUsers',
            'totalUsers',
            'newUsersCount',
            'incidentCount',
            'medicationCount',
            'abcChartCount',
            'otherCount',
            'formsTotal',
            'incidentPercent',
            'medicationPercent',
            'abcChartPercent',
            'otherPercent',
            'fromIncidentsCount',
            'latestSubmissions',
        ));
    }
}
