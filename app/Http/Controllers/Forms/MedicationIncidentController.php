<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationIncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medications = Medication::latest()->paginate(10);
        return view('pages.medication-incident', compact('medications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.form-medication');
    }

    /**
     * Store a newly created resource in storage.
     */
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
                'medication.submitted',
                'Medication incident report submitted (Client: ' . $request->cd_name . ', Location: ' . $request->cd_location . ')',
                $request->ip()
            );

            return redirect()->route('forms.medication.index')
                ->with('success', 'Medication incident report submitted successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit the report. Please try again.');
        }
    }

    public function show(string $id)
    {
        $medication = Medication::findOrFail($id);
        return view('pages.medication-show', compact('medication'));
    }

    public function edit(string $id)
    {
        $medication = Medication::findOrFail($id);
        return view('pages.medication-edit', compact('medication'));
    }

    public function update(Request $request, string $id)
    {
        $medication = Medication::findOrFail($id);

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
            $medication->update([
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

            return redirect()->route('forms.medication.index')
                ->with('success', 'Medication report updated successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update the report. Please try again.');
        }
    }

    public function destroy(string $id)
    {
        try {
            Medication::findOrFail($id)->delete();

            return redirect()->route('forms.medication.index')
                ->with('success', 'Record deleted successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->with('error', 'Failed to delete the record. Please try again.');
        }
    }
}
