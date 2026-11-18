<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateMedicationController extends Controller
{
    public function index()
    {
        return view('public-form.add-medication');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pr_name'                 => 'required|string|max:255',
            'pr_position'             => 'required|string|max:255',
            'pr_date_occured'         => 'required|date',
            'pr_time_occured'         => 'required',
            'pr_date_reported'        => 'required|date',
            'pr_incident_reported_to' => 'required|string|max:255',
            'cd_name'                 => 'required|string|max:255',
            'cd_location'             => 'required|string|max:255',
            'cd_responsible'          => 'nullable|string|max:255',
            'med_type'                => 'required|array|min:1',
            'med_type.*'              => 'string',
            'incident_background'     => 'required|string',
            'incident_details'        => 'required|string',
            'med_cause'               => 'nullable|array',
            'med_action'              => 'nullable|array',
            'med_follow'              => 'nullable|array',
            'action_explaination'     => 'nullable|string',
            'action_taken_by'         => 'nullable|string|max:255',
            'date_completed'          => 'nullable|date',
            'signature'               => 'nullable|string|max:255',
        ]);

        try {
            Medication::create([
                'pr_name'                 => $request->pr_name,
                'pr_position'             => $request->pr_position,
                'pr_date_occured'         => $request->pr_date_occured,
                'pr_time_occured'         => $request->pr_time_occured,
                'pr_date_reported'        => $request->pr_date_reported,
                'pr_incident_reported_to' => $request->pr_incident_reported_to,
                'cd_name'                 => $request->cd_name,
                'cd_location'             => $request->cd_location,
                'cd_responsible'          => $request->cd_responsible,
                'incident_type'           => implode(', ', $request->med_type),
                'incident_background'     => $request->incident_background,
                'incident_details'        => $request->incident_details,
                'cause_factor'            => $request->med_cause ? implode(', ', $request->med_cause) : null,
                'immediate_action'        => $request->med_action ? implode(', ', $request->med_action) : null,
                'follow_up_action'        => $request->med_follow ? implode(', ', $request->med_follow) : null,
                'action_explaination'     => $request->action_explaination,
                'action_taken_by'         => $request->action_taken_by,
                'date_completed'          => $request->date_completed,
                'signature'               => $request->signature,
            ]);

            ActivityLog::record(
                'public.medication.submitted',
                'Public medication incident report submitted (Client: ' . $request->cd_name . ', Location: ' . $request->cd_location . ')',
                $request->ip(),
                null,
                $request->pr_name
            );

            return redirect()->route('medication.public.create')
                ->with('success', 'Medication incident report submitted successfully. Thank you.');
        } catch (\Throwable $e) {
            Log::error('Public medication form submission failed', [
                'message' => $e->getMessage(),
                'ip'      => $request->ip(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit the report. Please try again.');
        }
    }
}
