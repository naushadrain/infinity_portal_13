<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CustomerSatisfaction;
use Illuminate\Http\Request;

class CustomerSatisfyController extends Controller
{
    public function index()
    {
        return view('public-form.customersatisfy');
    }
    public function getVictoria()
    {
        return view('public-form.customersatisfy-Victoria');
    }
    // stroe the cities name perth
    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_name'           => 'required|string|max:255',
            'overall_satisfy'     => 'required|integer|min:1|max:5',
            'employee_behave'     => 'required|integer|min:1|max:5',
            'resolving_ability'   => 'required|integer|min:1|max:5',
            'staff_will'          => 'required|integer|min:1|max:5',
            'employees_explain'   => 'required|integer|min:1|max:5',
            'rate_quality'        => 'required|integer|min:1|max:5',
            'like_recommend'      => 'required|integer|min:1|max:5',
            'meet_needs'          => 'required|integer|min:1|max:5',
            'suggestions'         => 'nullable|string|max:1000',
        ]);
        // Store data in database
        CustomerSatisfaction::create($validated);

        // Return success response
        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    // store the cities name victoria
    public function storeVictoria(Request $request)
    {
        $validated = $request->validate([
            'city_name'           => 'required|string|max:255',
            'overall_satisfy'     => 'required|integer|min:1|max:5',
            'employee_behave'     => 'required|integer|min:1|max:5',
            'resolving_ability'   => 'required|integer|min:1|max:5',
            'staff_will'          => 'required|integer|min:1|max:5',
            'employees_explain'   => 'required|integer|min:1|max:5',
            'rate_quality'        => 'required|integer|min:1|max:5',
            'like_recommend'      => 'required|integer|min:1|max:5',
            'meet_needs'          => 'required|integer|min:1|max:5',
            'suggestions'         => 'nullable|string|max:1000',
        ]);
        // Store data in database
        CustomerSatisfaction::create($validated);

        // Return success response
        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
