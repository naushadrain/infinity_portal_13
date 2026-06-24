<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ReporterDetail;
use App\Models\IncidentDetail;
use App\Models\IncidentType;
use App\Models\ParticipantsDetail;
use App\Models\StaffCarer;
use App\Models\WhatHappend;

class CreateIncidentController extends Controller
{
    public function index()
    {
        return view('public-form.add-incident');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reporter_name'     => ['required', 'string', 'max:255'],
            'contact_number'    => ['required', 'string', 'max:30'],
            'ir_number'         => ['nullable', 'string', 'max:100'],
            'position_title'    => ['nullable', 'string', 'max:255'],
            'city'              => ['required', 'string', 'max:100'],

            'incident_date'     => ['required', 'date'],
            'incident_time'     => ['required', 'string'],
            'incident_address'  => ['nullable', 'string', 'max:500'],
            'date_first_told'   => ['nullable', 'date'],
            'time_first_told'   => ['nullable', 'string'],
            'incident_type'     => ['required', 'array', 'min:1'],
            'incident_type.*'   => ['string'],

            'participant_name'              => ['required', 'string', 'max:255'],
            'participant_dob'               => ['nullable', 'date'],
            'participant_address'           => ['nullable', 'string', 'max:500'],
            'participant_involved_witness'  => ['nullable', 'string', 'max:50'],
            'participant_injured'           => ['nullable', 'string', 'max:10'],
            'participant_medical_attention' => ['nullable', 'string', 'max:10'],

            'staff_name'              => ['nullable', 'string', 'max:255'],
            'staff_address'           => ['nullable', 'string', 'max:500'],
            'staff_other'             => ['nullable', 'string', 'max:50'],
            'staff_involved_witness'  => ['nullable', 'string', 'max:50'],
            'staff_injured'           => ['nullable', 'string', 'max:10'],
            'staff_medical_attention' => ['nullable', 'string', 'max:10'],

            'incident_background'   => ['nullable', 'string'],
            'incident_description'  => ['required', 'string'],
            'immediate_action'      => ['required', 'string'],
            'property_damaged'      => ['nullable', 'string', 'max:10'],
            'police_contacted'      => ['nullable', 'string', 'max:10'],
            'damage_details'        => ['nullable', 'string'],
            'reported_to_manager'   => ['nullable', 'string', 'max:10'],
            'manager_name'          => ['nullable', 'string', 'max:255'],
            'report_date'           => ['nullable', 'date'],
            'reporter_signature'    => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $types = $request->input('incident_type', []);

            $reporter = ReporterDetail::create([
                'name'           => $request->reporter_name,
                'contact'        => $request->contact_number,
                'position_title' => $request->position_title,
                'city'           => $request->city,
                'ir_number'      => $request->ir_number,
                'completed'      => 0,
            ]);

            IncidentDetail::create([
                'r_id'                     => $reporter->id,
                'doi'                      => $request->incident_date,
                'toi'                      => $request->incident_time,
                'address'                  => $request->incident_address,
                'date_told_about_incident' => $request->date_first_told,
                'time_told_about_incident' => $request->time_first_told,
                'incident_background'      => $request->incident_background,
            ]);

            IncidentType::create([
                'r_id'              => $reporter->id,
                'absent'            => in_array('Absent/Missing persons', $types) ? 1 : 0,
                'behaviour'         => in_array('Behaviour', $types) ? 1 : 0,
                'confidentiality'   => in_array('Breach of Privacy/Confidentiality', $types) ? 1 : 0,
                'death'             => in_array('Death', $types) ? 1 : 0,
                'drug'              => in_array('Drug/Alcohol', $types) ? 1 : 0,
                'illness'           => in_array('Emergency', $types) ? 1 : 0,
                'medication_error'  => in_array('Medication', $types) ? 1 : 0,
                'assault'           => in_array('Physical/Restraint', $types) ? 1 : 0,
                'property_damage'   => in_array('Property damage', $types) ? 1 : 0,
                'self_harm'         => in_array('Self Abuse', $types) ? 1 : 0,
                'suicide_attempted' => in_array('Suicide Attempted', $types) ? 1 : 0,
                'other'             => in_array('Other', $types) ? 1 : 0,
                'near_miss'         => 0,
            ]);

            ParticipantsDetail::create([
                'r_id'             => $reporter->id,
                'full_name'        => $request->participant_name,
                'dob'              => $request->participant_dob,
                'address'          => $request->participant_address,
                'involved_witness' => $request->participant_involved_witness === 'Involved' ? 1 : 0,
                'injured'          => $request->participant_injured === 'Yes' ? 1 : 0,
                'medical_attention'=> $request->participant_medical_attention === 'Yes' ? 1 : 0,
            ]);

            if ($request->filled('staff_name')) {
                StaffCarer::create([
                    'r_id'             => $reporter->id,
                    'full_name'        => $request->staff_name,
                    'address'          => $request->staff_address,
                    'staff_other'      => strtoupper($request->staff_other ?? 'STAFF'),
                    'involved_witness' => $request->staff_involved_witness === 'Involved' ? 1 : 0,
                    'injured'          => $request->staff_injured === 'Yes' ? 1 : 0,
                    'medical_attention'=> $request->staff_medical_attention === 'Yes' ? 1 : 0,
                ]);
            }

            WhatHappend::create([
                'r_id'                    => $reporter->id,
                'desciption_of_incident'  => $request->incident_description,
                'actoin_taken_by_staff'   => $request->immediate_action,
                'property_damage'         => $request->property_damaged === 'Yes' ? 1 : 0,
                'police_contacted'        => $request->police_contacted === 'Yes' ? 1 : 0,
                'details_of_damage'       => $request->damage_details,
                'reported_to_line_manager'=> $request->reported_to_manager === 'Yes' ? 1 : 0,
                'manager_name'            => $request->manager_name,
                'date'                    => $request->report_date,
                'reporter_signature'      => $request->reporter_signature,
            ]);

            DB::commit();

            return redirect()->route('incident.public.create')
                ->with('success', 'Incident report submitted successfully. Thank you.');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Public incident form submission failed', [
                'message' => $e->getMessage(),
                'ip'      => $request->ip(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit incident report. Please try again.');
        }
    }
}
