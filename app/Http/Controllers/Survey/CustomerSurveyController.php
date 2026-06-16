<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Models\CustomerSatisfaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerSurveyController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->get('year');
        $selectedCity = $request->get('city');
        $search = $request->get('search');

        $years = CustomerSatisfaction::select(DB::raw('YEAR(created_at) as year'))
            ->whereNotNull('created_at')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $query = CustomerSatisfaction::query();

        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }

        if ($selectedCity && $selectedCity !== 'all') {
            $query->where('city_name', $selectedCity);
        }

        if ($search) {
            $query->where('city_name', 'like', '%' . $search . '%');
        }

        $customer = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.survey.customer-survey', compact(
            'customer',
            'years',
            'selectedYear',
            'selectedCity',
            'search'
        ));
    }
}