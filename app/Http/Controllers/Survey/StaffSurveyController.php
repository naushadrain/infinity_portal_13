<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Models\StaffSatisfaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffSurveyController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->get('year');
        $selectedCity = $request->get('city', 'all');
        $search = $request->get('search');

        $years = StaffSatisfaction::select(DB::raw('YEAR(created_at) as year'))
            ->whereNotNull('created_at')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $query = StaffSatisfaction::query();

        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }

        if ($selectedCity && $selectedCity !== 'all') {
            $query->where('city_name', $selectedCity);
        }

        if ($search) {
            $query->where('city_name', 'like', '%' . $search . '%');
        }

        $staffSurveys = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.survey.staff-survey', compact(
            'staffSurveys',
            'years',
            'selectedYear',
            'selectedCity',
            'search'
        ));
    }
}