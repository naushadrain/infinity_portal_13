<?php

namespace App\Http\Controllers;

use App\Models\CustomerSatisfaction;
use App\Models\IncidentDetail;
use App\Models\Medication;
use App\Models\PublicComplaint;
use App\Models\ReporterDetail;
use App\Models\StaffSatisfaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role_id == 2) {
            return redirect()->route('forms.incident.index');
        }

        // period = '30' (last 30 days) or 'all' (full DB, no date filter)
        $period  = $request->query('period', '30');
        $allTime = ($period === 'all');
        if (!$allTime) {
            $period = '30';
        }

        $since       = $allTime ? null : now()->subDays(30);
        $periodLabel = $allTime ? 'All time' : 'Last 30 days';

        // --- KPI cards ---
        $recentUsers   = User::with('role')->latest()->take(6)->get();
        $totalUsers    = User::whereIn('role_id', [2, 3])->count();
        $newUsersCount = $since
            ? User::whereIn('role_id', [2, 3])->where('created_at', '>=', $since)->count()
            : $totalUsers;

        $incidentCount   = $since ? ReporterDetail::where('created_at', '>=', $since)->count()        : ReporterDetail::count();
        $medicationCount = $since ? Medication::where('created_at', '>=', $since)->count()            : Medication::count();
        $otherCount      = 0;
        $formsTotal      = $incidentCount + $medicationCount;

        $surveyCount = ($since ? CustomerSatisfaction::where('created_at', '>=', $since) : CustomerSatisfaction::query())->count()
                     + ($since ? StaffSatisfaction::where('created_at', '>=', $since)    : StaffSatisfaction::query())->count();

        // incident_details has no timestamps — always all-time
        $fromIncidentsCount = IncidentDetail::count();

        // Previous-period comparison badge (only for "Last 30 days")
        $formsChange  = null;
        $surveyChange = null;
        if (!$allTime) {
            $prevSince = now()->subDays(60);
            $prevUntil = now()->subDays(30);

            $prevFormsTotal = ReporterDetail::whereBetween('created_at', [$prevSince, $prevUntil])->count()
                            + Medication::whereBetween('created_at', [$prevSince, $prevUntil])->count();

            $prevSurveyCount = CustomerSatisfaction::whereBetween('created_at', [$prevSince, $prevUntil])->count()
                             + StaffSatisfaction::whereBetween('created_at', [$prevSince, $prevUntil])->count();

            $formsChange  = $prevFormsTotal  > 0 ? round((($formsTotal  - $prevFormsTotal)  / $prevFormsTotal)  * 100) : null;
            $surveyChange = $prevSurveyCount > 0 ? round((($surveyCount - $prevSurveyCount) / $prevSurveyCount) * 100) : null;
        }

        // --- Donut chart percentages ---
        $incidentPercent   = $formsTotal > 0 ? round(($incidentCount   / $formsTotal) * 100) : 0;
        $medicationPercent = $formsTotal > 0 ? round(($medicationCount / $formsTotal) * 100) : 0;
        $otherPercent      = 0;

        // --- Graph data: Perth vs Victoria — month / year / all ---
        $chartData = $this->buildChartData();

        // --- Latest submissions table ---
        $latestSubmissions = $this->buildLatestSubmissions();

        // --- Missing Manager's Note ---
        $missingManagerNote = [
            'incident'   => ReporterDetail::whereNull('manager_note')->orWhere('manager_note', '')->count(),
            'medication' => Medication::whereNull('manager_note')->orWhere('manager_note', '')->count(),
            'complaint'  => PublicComplaint::whereNull('manager_note')->orWhere('manager_note', '')->count(),
        ];

        return view('pages.dashboard', compact(
            'recentUsers', 'totalUsers', 'newUsersCount',
            'incidentCount', 'medicationCount', 'otherCount', 'surveyCount',
            'formsTotal', 'incidentPercent', 'medicationPercent', 'otherPercent',
            'fromIncidentsCount', 'latestSubmissions', 'chartData', 'period', 'periodLabel',
            'formsChange', 'surveyChange', 'missingManagerNote',
        ));
    }

    // -------------------------------------------------------------------------

    private function buildChartData(): array
    {
        $earliestDate = collect([
            ReporterDetail::min('created_at'),
            Medication::min('created_at'),
        ])->filter()->min();

        $startYear = $earliestDate ? \Carbon\Carbon::parse($earliestDate)->year : now()->year;
        $allYears  = max(now()->year - $startYear + 1, 1);
        $fetchFrom = \Carbon\Carbon::create($startYear)->startOfYear();

        $incidents = ReporterDetail::where('created_at', '>=', $fetchFrom)
            ->select('created_at')->get()->map(fn($r) => $r->created_at);

        $medications = Medication::where('created_at', '>=', $fetchFrom)
            ->select('created_at')->get()->map(fn($r) => $r->created_at);

        return [
            'month' => $this->aggregateByType($incidents, $medications, 'month', 12),
            'year'  => $this->aggregateByType($incidents, $medications, 'year', min($allYears, 5)),
            'all'   => $this->aggregateByType($incidents, $medications, 'year', $allYears),
        ];
    }

    private function aggregateByType(
        \Illuminate\Support\Collection $incidents,
        \Illuminate\Support\Collection $medications,
        string $unit,
        int $count
    ): array {
        $labels     = [];
        $incidentD  = [];
        $medicationD = [];

        for ($i = $count - 1; $i >= 0; $i--) {
            [$label, $start, $end] = match ($unit) {
                'month' => [
                    now()->startOfMonth()->subMonths($i)->format('M y'),
                    now()->startOfMonth()->subMonths($i)->copy(),
                    now()->startOfMonth()->subMonths($i)->copy()->endOfMonth(),
                ],
                'year' => [
                    (string) (now()->year - $i),
                    now()->startOfYear()->subYears($i)->copy(),
                    now()->startOfYear()->subYears($i)->copy()->endOfYear(),
                ],
            };

            $labels[]      = $label;
            $incidentD[]   = $incidents->filter(fn($d)   => $d >= $start && $d <= $end)->count();
            $medicationD[] = $medications->filter(fn($d) => $d >= $start && $d <= $end)->count();
        }

        return [
            'labels'     => $labels,
            'incident'   => $incidentD,
            'medication' => $medicationD,
        ];
    }

    private function buildLatestSubmissions(): \Illuminate\Support\Collection
    {
        $submissions = collect();

        ReporterDetail::latest()->take(5)->get()->each(function ($item) use ($submissions) {
            $submissions->push([
                'ref'  => $item->ir_number ? '#' . $item->ir_number : '#INC-' . $item->id,
                'type' => 'Incident',
                'name' => $item->name,
                'city' => $item->city ?? '—',
                'when' => $item->created_at,
            ]);
        });

        Medication::latest()->take(5)->get()->each(function ($item) use ($submissions) {
            $submissions->push([
                'ref'  => '#MED-' . $item->id,
                'type' => 'Medication',
                'name' => $item->pr_name,
                'city' => $item->cd_location ?? '—',
                'when' => $item->created_at,
            ]);
        });

        return $submissions->sortByDesc('when')->take(10)->values();
    }
}
