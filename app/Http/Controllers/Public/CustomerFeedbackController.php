<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CustomerFeedback;
use Illuminate\Http\Request;

class CustomerFeedbackController extends Controller
{
    public function index()
    {
        return view('public-form.customersatisfy-feedback');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_name'             => 'nullable|string|max:255',
            'name'                  => 'nullable|string|max:255',
            'email'                 => 'nullable|email|max:255',
            'address'               => 'nullable|string|max:255',
            'wants_interpreter'     => 'nullable|boolean',
            'interpreter_language'  => 'nullable|string|max:255',
            'wants_response'        => 'nullable|boolean',
            'preferred_contact_method' => 'nullable|in:email,phone,post',
            'feedback_type'         => 'nullable|in:compliment,complaint,comment',
            'respondent_type'       => 'nullable|in:participant,family_member,participants_representative,staff_member,staff_on_behalf_of_participant,other',
            'respondent_type_other' => 'nullable|string|max:255',
            'experience'            => 'nullable|string|max:2000',
            'suggestions'           => 'nullable|string|max:2000',
        ]);

        CustomerFeedback::create($validated);

        ActivityLog::record(
            'customer.feedback.submitted',
            'Feedback/compliment/complaint form submitted (City: ' . ($validated['city_name'] ?? 'N/A') . ')',
            $request->ip(),
            null,
            'Guest'
        );

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
