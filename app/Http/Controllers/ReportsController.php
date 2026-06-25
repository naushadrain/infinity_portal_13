<?php

namespace App\Http\Controllers;

use App\Models\AbcParticipantDetail;
use App\Models\CustomerSatisfaction;
use App\Models\IncidentType;
use App\Models\Medication;
use App\Models\ReporterDetail;
use App\Models\StaffSatisfaction;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $city = $request->input('city', '');

        $since = now()->subDays($days);

        // ── Form counts (date-filtered) ────────────────────────────────────────
        $incidentQuery   = ReporterDetail::where('created_at', '>=', $since);
        $medicationQuery = Medication::where('created_at', '>=', $since);
        $abcQuery        = AbcParticipantDetail::where('created_at', '>=', $since);

        if ($city !== '') {
            $incidentQuery->where('city', $city);
        }

        $incidentCount   = $incidentQuery->count();
        $medicationCount = $medicationQuery->count();
        $abcCount        = $abcQuery->count();
        $totalForms      = $incidentCount + $medicationCount + $abcCount;

        // ── Survey counts ──────────────────────────────────────────────────────
        $customerSurveyCount = CustomerSatisfaction::where('created_at', '>=', $since)->count();
        $staffSurveyCount    = StaffSatisfaction::where('created_at', '>=', $since)->count();
        $totalSurveys        = $customerSurveyCount + $staffSurveyCount;

        // ── Completed vs pending (incidents only) ──────────────────────────────
        $completedCount = ReporterDetail::where('created_at', '>=', $since)->where('completed', 1)->count();
        $pendingCount   = ReporterDetail::where('created_at', '>=', $since)->where('completed', 0)->count();

        // ── Trend: compare current period with previous period ─────────────────
        $prevSince = now()->subDays($days * 2);
        $prevUntil = now()->subDays($days);

        $prevTotal = ReporterDetail::whereBetween('created_at', [$prevSince, $prevUntil])->count()
            + Medication::whereBetween('created_at', [$prevSince, $prevUntil])->count()
            + AbcParticipantDetail::whereBetween('created_at', [$prevSince, $prevUntil])->count();

        $formsTrend = $prevTotal > 0
            ? round((($totalForms - $prevTotal) / $prevTotal) * 100)
            : ($totalForms > 0 ? 100 : 0);

        $prevSurveys = CustomerSatisfaction::whereBetween('created_at', [$prevSince, $prevUntil])->count()
            + StaffSatisfaction::whereBetween('created_at', [$prevSince, $prevUntil])->count();

        $surveysTrend = $prevSurveys > 0
            ? round((($totalSurveys - $prevSurveys) / $prevSurveys) * 100)
            : ($totalSurveys > 0 ? 100 : 0);

        // ── Incident type breakdown (all-time aggregate from IncidentType) ─────
        $typeRow = IncidentType::selectRaw('
            SUM(behaviour)         as behaviour,
            SUM(near_miss)         as near_miss,
            SUM(illness)           as illness,
            SUM(property_damage)   as property_damage,
            SUM(absent)            as absent,
            SUM(assault)           as assault,
            SUM(drug)              as drug,
            SUM(self_harm)         as self_harm,
            SUM(suicide_attempted) as suicide_attempted,
            SUM(death)             as death,
            SUM(confidentiality)   as confidentiality,
            SUM(other)             as other
        ')->first();

        $incidentTypes = [
            'Behaviour'          => (int) ($typeRow->behaviour ?? 0),
            'Near Miss'          => (int) ($typeRow->near_miss ?? 0),
            'Illness / Injury'   => (int) ($typeRow->illness ?? 0),
            'Property Damage'    => (int) ($typeRow->property_damage ?? 0),
            'Absent / Missing'   => (int) ($typeRow->absent ?? 0),
            'Assault'            => (int) ($typeRow->assault ?? 0),
            'Drug / Alcohol'     => (int) ($typeRow->drug ?? 0),
            'Self-Harm'          => (int) ($typeRow->self_harm ?? 0),
            'Suicide Attempted'  => (int) ($typeRow->suicide_attempted ?? 0),
            'Death'              => (int) ($typeRow->death ?? 0),
            'Confidentiality'    => (int) ($typeRow->confidentiality ?? 0),
            'Other'              => (int) ($typeRow->other ?? 0),
        ];
        arsort($incidentTypes);
        $topIncidentTypes = array_slice($incidentTypes, 0, 5, true);

        // ── Regional breakdown ─────────────────────────────────────────────────
        $cityNames = config('settings.city_name', []);
        $regionRaw = ReporterDetail::where('created_at', '>=', $since)
            ->selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->pluck('total', 'city')
            ->toArray();

        $regionBreakdown = [];
        foreach ($regionRaw as $key => $count) {
            $regionBreakdown[$cityNames[$key] ?? ('Region ' . $key)] = $count;
        }

        // ── Bar-chart widths (relative to max form type) ───────────────────────
        $maxForms = max($incidentCount, $medicationCount, $abcCount, 1);

        return view('pages.reports', compact(
            'incidentCount',
            'medicationCount',
            'abcCount',
            'totalForms',
            'totalSurveys',
            'customerSurveyCount',
            'staffSurveyCount',
            'completedCount',
            'pendingCount',
            'formsTrend',
            'surveysTrend',
            'topIncidentTypes',
            'regionBreakdown',
            'maxForms',
            'days',
            'city',
            'cityNames',
        ));
    }
}
