<?php

namespace App\Http\Controllers;

use App\Models\AbcParticipantDetail;
use App\Models\IncidentDetail;
use App\Models\Medication;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $recentUsers = User::with('role')
            ->latest()
            ->take(6)
            ->get();

        $totalUsers = User::whereIn('role_id', [2, 3])->count();
        $fromIncidentsCount = IncidentDetail::count();
        $newUsersCount = User::whereIn('role_id', [2, 3])
            ->where('created_at', '>=', now()->subWeek())
            ->count();

        $incidentCount = IncidentDetail::where('doi', '>=', now()->subDays(30))->count();
        $medicationCount = Medication::where('created_at', '>=', now()->subDays(30))->count();
        $abcChartCount = AbcParticipantDetail::where('created_at', '>=', now()->subDays(30))->count();

        $otherCount = 0;

        $formsTotal = $incidentCount + $medicationCount + $abcChartCount + $otherCount;

        $incidentPercent = $formsTotal > 0 ? round(($incidentCount / $formsTotal) * 100) : 0;
        $medicationPercent = $formsTotal > 0 ? round(($medicationCount / $formsTotal) * 100) : 0;
        $abcChartPercent = $formsTotal > 0 ? round(($abcChartCount / $formsTotal) * 100) : 0;
        $otherPercent = $formsTotal > 0 ? round(($otherCount / $formsTotal) * 100) : 0;

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
            'otherPercent','fromIncidentsCount'
        ));
    }
}