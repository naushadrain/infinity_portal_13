<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use App\Models\CustomerSatisfaction;
use App\Models\IncidentDetail;
use App\Models\Medication;
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
        $feedbackCount   = $since ? CustomerFeedback::where('created_at', '>=', $since)->count()      : CustomerFeedback::count();
        $otherCount      = $feedbackCount;
        $formsTotal      = $incidentCount + $medicationCount + $feedbackCount;

        // Period-scoped "X completed" subtext under the Incidents/Medication KPI tiles —
        // records marked completed (updated) within this period, so completing an older
        // record today counts under "Last 30 days" even though it wasn't created then.
        $incidentCompletedCount   = ReporterDetail::where('completed', 1)->when($since, fn($q) => $q->where('updated_at', '>=', $since))->count();
        $medicationCompletedCount = Medication::where('completed', 1)->when($since, fn($q) => $q->where('updated_at', '>=', $since))->count();

        // Status card — live, all-time snapshot (not period-scoped), so marking an older
        // record Completed today is reflected immediately regardless of the period filter.
        $incidentActiveCount      = ReporterDetail::where('completed', 0)->count();
        $incidentStatusCompleted  = ReporterDetail::where('completed', 1)->count();
        $medicationActiveCount    = Medication::where('completed', 0)->count();
        $medicationStatusCompleted = Medication::where('completed', 1)->count();
        $complaintActiveCount     = CustomerFeedback::where('status', '!=', 'Closed')->count();
        $complaintStatusCompleted = CustomerFeedback::where('status', 'Closed')->count();

        // Complaint status breakdown — New / In Progress / Closed, all-time, for the pie chart.
        $complaintStatusCounts = [
            'new'         => CustomerFeedback::where('status', 'New')->count(),
            'in_progress' => CustomerFeedback::where('status', 'In Progress')->count(),
            'closed'      => CustomerFeedback::where('status', 'Closed')->count(),
        ];
        $complaintStatusTotal = array_sum($complaintStatusCounts);
        $complaintStatusPercents = array_map(
            fn($count) => $complaintStatusTotal > 0 ? round(($count / $complaintStatusTotal) * 100) : 0,
            $complaintStatusCounts
        );

        // incident_details has no timestamps — always all-time
        $fromIncidentsCount = IncidentDetail::count();

        // Previous-period comparison badge (only for "Last 30 days")
        $formsChange    = null;
        $feedbackChange = null;
        if (!$allTime) {
            $prevSince = now()->subDays(60);
            $prevUntil = now()->subDays(30);

            $prevFeedbackCount = CustomerFeedback::whereBetween('created_at', [$prevSince, $prevUntil])->count();

            $prevFormsTotal = ReporterDetail::whereBetween('created_at', [$prevSince, $prevUntil])->count()
                            + Medication::whereBetween('created_at', [$prevSince, $prevUntil])->count()
                            + $prevFeedbackCount;

            $formsChange    = $prevFormsTotal    > 0 ? round((($formsTotal    - $prevFormsTotal)    / $prevFormsTotal)    * 100) : null;
            $feedbackChange = $prevFeedbackCount > 0 ? round((($feedbackCount - $prevFeedbackCount) / $prevFeedbackCount) * 100) : null;
        }

        // --- Donut chart percentages ---
        $incidentPercent   = $formsTotal > 0 ? round(($incidentCount   / $formsTotal) * 100) : 0;
        $medicationPercent = $formsTotal > 0 ? round(($medicationCount / $formsTotal) * 100) : 0;
        $otherPercent      = $formsTotal > 0 ? round(($otherCount      / $formsTotal) * 100) : 0;

        // --- Graph data: Perth vs Victoria — month / year / all ---
        $chartData = $this->buildChartData();

        // --- Latest submissions table ---
        $latestSubmissions = $this->buildLatestSubmissions();

        return view('pages.dashboard', compact(
            'recentUsers', 'totalUsers', 'newUsersCount',
            'incidentCount', 'medicationCount', 'otherCount', 'feedbackCount',
            'formsTotal', 'incidentPercent', 'medicationPercent', 'otherPercent',
            'fromIncidentsCount', 'latestSubmissions', 'chartData', 'period', 'periodLabel',
            'formsChange', 'feedbackChange',
            'incidentCompletedCount', 'medicationCompletedCount',
            'incidentActiveCount', 'medicationActiveCount',
            'incidentStatusCompleted', 'medicationStatusCompleted',
            'complaintActiveCount', 'complaintStatusCompleted',
            'complaintStatusCounts', 'complaintStatusTotal', 'complaintStatusPercents',
        ));
    }

    // -------------------------------------------------------------------------

    private function buildChartData(): array
    {
        $earliestDate = collect([
            ReporterDetail::min('created_at'),
            Medication::min('created_at'),
            CustomerFeedback::min('created_at'),
            CustomerSatisfaction::min('created_at'),
            StaffSatisfaction::min('created_at'),
        ])->filter()->min();

        $startYear = $earliestDate ? \Carbon\Carbon::parse($earliestDate)->year : now()->year;
        $allYears  = max(now()->year - $startYear + 1, 1);
        $fetchFrom = \Carbon\Carbon::create($startYear)->startOfYear();

        $incidents = ReporterDetail::where('created_at', '>=', $fetchFrom)
            ->select('created_at')->get()->map(fn($r) => $r->created_at);

        $medications = Medication::where('created_at', '>=', $fetchFrom)
            ->select('created_at')->get()->map(fn($r) => $r->created_at);

        $feedback = CustomerFeedback::where('created_at', '>=', $fetchFrom)
            ->select('created_at')->get()->map(fn($r) => $r->created_at);

        $surveys = CustomerSatisfaction::where('created_at', '>=', $fetchFrom)
            ->select('created_at')->get()->map(fn($r) => $r->created_at)
            ->concat(
                StaffSatisfaction::where('created_at', '>=', $fetchFrom)
                    ->select('created_at')->get()->map(fn($r) => $r->created_at)
            );

        return [
            'month' => $this->aggregateByType($incidents, $medications, $feedback, $surveys, 'month', 12),
            'year'  => $this->aggregateByType($incidents, $medications, $feedback, $surveys, 'year', min($allYears, 5)),
            'all'   => $this->aggregateByType($incidents, $medications, $feedback, $surveys, 'year', $allYears),
        ];
    }

    private function aggregateByType(
        \Illuminate\Support\Collection $incidents,
        \Illuminate\Support\Collection $medications,
        \Illuminate\Support\Collection $feedback,
        \Illuminate\Support\Collection $surveys,
        string $unit,
        int $count
    ): array {
        $labels      = [];
        $incidentD   = [];
        $medicationD = [];
        $feedbackD   = [];
        $surveyD     = [];

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
            $feedbackD[]   = $feedback->filter(fn($d)     => $d >= $start && $d <= $end)->count();
            $surveyD[]     = $surveys->filter(fn($d)      => $d >= $start && $d <= $end)->count();
        }

        return [
            'labels'     => $labels,
            'incident'   => $incidentD,
            'medication' => $medicationD,
            'feedback'   => $feedbackD,
            'survey'     => $surveyD,
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
