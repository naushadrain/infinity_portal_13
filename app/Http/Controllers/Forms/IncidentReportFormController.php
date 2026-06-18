<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncidentForm;
use App\Models\IncidentDetail;
use App\Models\IncidentType;
use App\Models\ReporterDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IncidentReportFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ReporterDetail::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ir_number', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        if ($city = $request->input('city')) {
            $query->where('city', $city);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $incidents = $query->paginate(10)->withQueryString();

        return view('pages.forms', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.form-incident');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:30'],
            'incident_report_number' => ['nullable', 'string', 'max:100'],
            'position_title' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],

            'incident_date' => ['required', 'date'],
            'incident_time' => ['required'],
            'date_first_told' => ['nullable', 'date'],
            'incident_address' => ['required', 'string', 'max:500'],
            'incident_type' => ['required', 'array', 'min:1'],

            'participant_name' => ['required', 'string', 'max:255'],
            'participant_dob' => ['nullable', 'date'],
            'participant_type' => ['nullable', 'string', 'max:100'],
            'participant_address' => ['nullable', 'string', 'max:500'],
            'participant_injured' => ['required', 'in:Yes,No'],
            'participant_medical_attention' => ['required', 'in:Yes,No'],

            'incident_background' => ['nullable', 'string'],
            'incident_description' => ['required', 'string'],
            'immediate_action' => ['required', 'string'],
            'property_damaged' => ['required', 'in:Yes,No'],
            'police_contacted' => ['required', 'in:Yes,No'],

            'manager_signature' => ['nullable', 'string', 'max:255'],
            'reportable_incident' => ['required', 'in:Yes,No'],
        ]);

        try {
            DB::beginTransaction();

            $incidentTypes = $validated['incident_type'];

            $form = IncidentForm::create([
                'added_by'                  => Auth::id(),
                'email_sent'                => false,
                'name'                      => $validated['reporter_name'],
                'category'                  => $validated['city'],
                'department_work_incident'  => $validated['position_title'] ?? null,
                'date_incident'             => $validated['incident_date'],
                'time_incident'             => $validated['incident_time'],
                'address_location_incident' => $validated['incident_address'],
                'detail_incident'           => $validated['incident_description'],
                'immediate_action_taken'    => $validated['immediate_action'],
                'report_incident_date_name' => $validated['incident_report_number'] ?? null,
                'police_notified'           => $validated['police_contacted'],
                'client_name'               => $validated['participant_name'],
                'client_dob'                => $validated['participant_dob'] ?? null,
                'name_dob_client'           => trim($validated['participant_name'] . ' ' . ($validated['participant_dob'] ?? '')),
                'was_injuries_sustained'    => $validated['participant_injured'],
                'was_treatment_required'    => $validated['participant_medical_attention'],
                'was_property_damaged'      => $validated['property_damaged'],
                'was_incident_reported'     => $validated['reportable_incident'],
                'ip_address'                => $request->ip(),
            ]);

            IncidentDetail::create([
                'r_id'                     => $form->getKey(),
                'doi'                      => $validated['incident_date'],
                'toi'                      => $validated['incident_time'],
                'address'                  => $validated['incident_address'],
                'date_told_about_incident' => $validated['date_first_told'] ?? null,
                'incident_background'      => $validated['incident_background'] ?? null,
                'sign_box'                 => $validated['manager_signature'] ?? null,
                'manager_sign_date'        => now()->toDateString(),
            ]);

            IncidentType::create([
                'r_id'              => $form->getKey(),
                'absent'            => in_array('Absent/Missing person', $incidentTypes),
                'behaviour'         => in_array('Behaviour', $incidentTypes),
                'confidentiality'   => in_array('Breach of Privacy', $incidentTypes),
                'drug'              => in_array('Drug/Alcohol', $incidentTypes),
                'illness'           => in_array('Illness/Injury', $incidentTypes),
                'assault'           => in_array('Assault (Physical/Sexual)', $incidentTypes),
                'property_damage'   => in_array('Property Damage', $incidentTypes),
                'self_harm'         => in_array('Self-Harm', $incidentTypes),
                'suicide_attempted' => in_array('Suicide Attempted', $incidentTypes),
                'death'             => in_array('Death', $incidentTypes),
                'other'             => in_array('Other', $incidentTypes),
                'near_miss'         => in_array('Near Miss', $incidentTypes),
            ]);

            DB::commit();

            return redirect()
                ->route('forms.incident.index')
                ->with('success', 'Incident report submitted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Incident form submit failed', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to submit incident report. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incident = IncidentForm::findOrFail($id);

        IncidentDetail::where('r_id', $incident->getKey())->delete();
        IncidentType::where('r_id', $incident->getKey())->delete();
        $incident->delete();

        return redirect()->route('forms.incident.index')->with('success', 'Incident report deleted.');
    }
}
