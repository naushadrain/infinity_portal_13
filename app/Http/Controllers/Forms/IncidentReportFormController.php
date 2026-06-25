<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\IncidentForm;
use App\Models\IncidentDetail;
use App\Models\IncidentType;
use App\Models\ReporterDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ParticipantsDetail;
use App\Models\StaffCarer;
use App\Models\WhatHappend;
use App\Models\ManagerReport;
use Codedge\Fpdf\Facades\Fpdf;

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

        $incidents = $query->paginate(50)->withQueryString();

        return view('pages.forms', compact('incidents'));
    }

    public function export(Request $request)
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

        $incidents = $query->get();
        $cityNames = config('settings.city_name', []);

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="incidents.csv"',
        ];

        $callback = function () use ($incidents, $cityNames) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Sr. No.', 'Submitted', 'Reporter Name', 'Contact', 'IR Number', 'Position', 'City', 'Status']);

            foreach ($incidents as $i => $incident) {
                fputcsv($file, [
                    $i + 1,
                    $incident->created_at->format('d M Y'),
                    $incident->name ?? '',
                    $incident->contact ?? '',
                    $incident->ir_number ?? '',
                    $incident->position_title ?? '',
                    $cityNames[$incident->city] ?? $incident->city ?? '',
                    $incident->completed ? 'Completed' : 'Pending',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.form-incident');
    }

    public function showPdf($r_id)
    {
        $reporter     = ReporterDetail::findOrFail($r_id);
        $incident     = IncidentDetail::where('r_id', $reporter->id)->first();
        $incidentType = IncidentType::where('r_id', $reporter->id)->first();
        $participant  = ParticipantsDetail::where('r_id', $reporter->id)->first();
        $staff        = StaffCarer::where('r_id', $reporter->id)->first();
        $whatHappend  = WhatHappend::where('r_id', $reporter->id)->first();
        $manager      = ManagerReport::where('r_id', $reporter->id)->first();

        // ── Page setup ────────────────────────────────────────────────────────
        Fpdf::AddPage();
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Image(public_path('assets/logo.png'), 5, 3, 50);
        Fpdf::Ln(22);
        Fpdf::Cell(190, 5, 'Participant Incident Report Form:', 0, 1, 'C');
        Fpdf::Ln(2);
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::MultiCell(0, 5, 'Complete this form to report incidents involving and/or impacting upon Participants in services delivered by Infinite Ability.');
        Fpdf::Ln(6);

        // ── Part 1: Reporter Details ───────────────────────────────────────────
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Cell(190, 5, 'Part 1: Reporter Details', 0, 1, 'L');
        Fpdf::Ln(3);

        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(70, 5, 'Name of the person reporting this incident:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(120, 5, $reporter->name ?? '', 1, 1, 'L');

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(70, 5, 'Contact number:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(120, 5, $reporter->contact ?? '', 1, 1, 'L');

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(70, 5, 'Position Title:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(120, 5, $reporter->position_title ?? '', 1, 1, 'L');

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(70, 5, 'Incident Report Number:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(120, 5, $reporter->ir_number ?? '', 1, 1, 'L');
        Fpdf::Ln(6);

        // ── Part 2: Incident Details ───────────────────────────────────────────
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Cell(190, 5, 'Part 2: Incident Details', 0, 1, 'L');
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Ln(3);

        Fpdf::Cell(30, 5, 'Date of incident:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::Cell(65, 5, $incident->doi ?? '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(30, 5, 'Time of incident:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::Cell(65, 5, $incident->toi ?? '', 1, 1, 'L');

        Fpdf::SetFillColor(255, 242, 204);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(190, 5, 'If you did not see the incident:', 1, 1, 'L', 1);
        $y = Fpdf::GetY();
        $x = Fpdf::GetX();
        Fpdf::MultiCell(40, 4, "Date first told you about the\nincident:", 1);
        Fpdf::SetXY($x + 40, $y);
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::Cell(55, 8, $incident->date_told_about_incident ?? '', 1, 0, 'L');

        $y = Fpdf::GetY();
        $x = Fpdf::GetX();
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::MultiCell(40, 4, "Time first told you about\nthe incident:", 1);
        Fpdf::SetXY($x + 40, $y);
        Fpdf::SetFont('Arial', '', 8);
        Fpdf::Cell(55, 8, $incident->time_told_about_incident ?? '', 1, 1, 'L');

        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(40, 5, 'Address/location of Incident', 1, 0);
        Fpdf::Cell(150, 5, $incident->address ?? '', 1, 1, 'L');

        Fpdf::SetFillColor(255, 242, 204);
        Fpdf::Cell(190, 5, 'Incident Type (Select one the most appropriate incident Type):', 1, 1, 'L', 1);

        // Checkboxes row 1
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Ln(3);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->absent) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Absent/Missing person', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->behaviour) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Behaviour', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->death) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(40, 5, 'Death', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->confidentiality) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Breach of Privacy/Confidentiality', 0, 1);

        // Checkboxes row 2
        Fpdf::Ln(3);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->drug) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Drug/Alcohol', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->illness) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Illness/Injury', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && isset($incidentType->medication_error) && $incidentType->medication_error) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(40, 5, 'Medication error', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->assault) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Assault(Physical/Sexual)', 0, 1);

        // Checkboxes row 3
        Fpdf::Ln(3);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->property_damage) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Property damage', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->self_harm) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Self-harm', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->suicide_attempted) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(40, 5, 'Suicide Attempted', 0, 0);
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, ($incidentType && $incidentType->other) ? chr(52) : '', 1, 0);
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(42.5, 5, 'Other', 0, 1);

        // ── Part 3: Who was involved ───────────────────────────────────────────
        Fpdf::Ln(6);
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Cell(190, 5, 'Part 3: Who was involved?', 0, 1, 'L');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::Cell(190, 5, 'Participants: details', 0, 1, 'L');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(190, 5, 'Please complete for each Participant involved in the incident. This includes Participant witnesses.', 0, 1, 'L');
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(40, 5, 'Full Name', 1, 0, 'L');
        Fpdf::Cell(20, 5, 'DOB', 1, 0, 'L');
        Fpdf::Cell(40, 5, 'Address', 1, 0, 'L');
        Fpdf::Cell(30, 5, 'Involved/Witness', 1, 0, 'L');
        Fpdf::Cell(15, 5, 'Injured', 1, 0, 'L');
        Fpdf::Cell(40, 5, 'Medical Attention required?', 1, 1, 'L');

        Fpdf::SetFont('Arial', '', 8);
        if ($participant) {
            $cx = Fpdf::GetX();
            $cy = Fpdf::GetY();
            $addrLen = strlen($participant->address ?? '');
            Fpdf::MultiCell(40, 8, $participant->full_name ?? '', 1, 'L', 0);
            Fpdf::SetXY($cx + 40, $cy);
            $cx = Fpdf::GetX();
            Fpdf::MultiCell(20, 8, $participant->dob ?? '', 1, 'L', 0);
            Fpdf::SetXY($cx + 20, $cy);
            $cx = Fpdf::GetX();
            if ($addrLen < 25) {
                Fpdf::MultiCell(40, 8, $participant->address ?? '', 1, 'L', 0);
            } else {
                Fpdf::MultiCell(40, 4, $participant->address ?? '', 1, 'L', 0);
            }
            Fpdf::SetXY($cx + 40, $cy);
            $cx = Fpdf::GetX();
            Fpdf::MultiCell(30, 8, $participant->involved_witness ? 'Yes' : 'No', 1, 'L', 0);
            Fpdf::SetXY($cx + 30, $cy);
            $cx = Fpdf::GetX();
            Fpdf::MultiCell(15, 8, $participant->injured ? 'Yes' : 'No', 1, 'L', 0);
            Fpdf::SetXY($cx + 15, $cy);
            $cx = Fpdf::GetX();
            Fpdf::MultiCell(40, 8, $participant->medical_attention ? 'Yes' : 'No', 1, 'L', 0);
        }
        Fpdf::Ln(8);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::Cell(190, 5, 'Staff/Career or Others: details', 0, 1, 'L');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(190, 5, 'Please complete for each staff member/career or Others involved in the incident, including any witnesses.', 0, 1, 'L');
        Fpdf::SetFont('Arial', 'B', 8);
        Fpdf::Cell(40, 5, 'Full Name', 1, 0, 'L');
        Fpdf::Cell(40, 5, 'Address', 1, 0, 'L');
        Fpdf::Cell(20, 5, 'Staff/Others', 1, 0, 'L');
        Fpdf::Cell(30, 5, 'Involved/Witness', 1, 0, 'L');
        Fpdf::Cell(15, 5, 'Injured', 1, 0, 'L');
        Fpdf::Cell(40, 5, 'Medical Attention required?', 1, 1, 'L');

        Fpdf::SetFont('Arial', '', 8);
        if ($staff) {
            Fpdf::Cell(40, 5, $staff->full_name ?? '', 1, 0, 'L');
            Fpdf::Cell(40, 5, $staff->address ?? '', 1, 0, 'L');
            Fpdf::Cell(20, 5, ($staff->staff_other === 'STAFF') ? 'Staff' : 'Other', 1, 0, 'L');
            Fpdf::Cell(30, 5, $staff->involved_witness ? 'Yes' : 'No', 1, 0, 'L');
            Fpdf::Cell(15, 5, (isset($staff->injured) && $staff->injured) ? 'Yes' : 'No', 1, 0, 'L');
            Fpdf::Cell(40, 5, $staff->medical_attention ? 'Yes' : 'No', 1, 1, 'L');
        }

        // ── Part 4: Incident Background ────────────────────────────────────────
        Fpdf::Ln(3);
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Cell(70, 10, 'Part 4: Incident Background (eg. What was client doing before incident):', 0, 1, 'L');
        Fpdf::SetFont('Arial', '', 10);
        $bg = iconv('UTF-8', 'ASCII//TRANSLIT', $incident->incident_background ?? '');
        Fpdf::MultiCell(0, 5, $bg, 1);
        Fpdf::Ln(1);

        // ── Part 5: What happened ──────────────────────────────────────────────
        Fpdf::Ln(6);
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Cell(190, 5, 'Part 5: What happened?', 0, 1, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(190, 5, 'Describe the incident', 0, 1, 'L');
        Fpdf::MultiCell(0, 4, '(This section should be a detail, factual account of incident. Include what task was performing at the time of incident, impact on Participant; who was involved; how; where and when the incident occurred; who did what; if applicable: who was injured and the nature and extent of injuries).');
        Fpdf::Ln(4);
        Fpdf::SetFont('Arial', '', 8);
        $desc = iconv('UTF-8', 'ASCII//TRANSLIT', $whatHappend->desciption_of_incident ?? '');
        Fpdf::MultiCell(0, 5, $desc, 1);
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(60, 8, 'Immediate action taken by Staff:', 0, 1, 'L');
        Fpdf::Ln(2);
        Fpdf::SetFont('Arial', '', 8);
        $staffAction = iconv('UTF-8', 'ASCII//TRANSLIT', $whatHappend->actoin_taken_by_staff ?? '');
        if (strlen($whatHappend->actoin_taken_by_staff ?? '') < 60) {
            Fpdf::MultiCell(0, 15, $staffAction, 1);
        } else {
            Fpdf::MultiCell(0, 5, $staffAction, 1);
        }
        Fpdf::Ln(10);

        $propDmg    = $whatHappend->property_damage ?? 0;
        $policeCont = $whatHappend->police_contacted ?? 0;
        $lineRep    = $whatHappend->reported_to_line_manager ?? 0;

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(60, 5, 'Was any property or equipment damaged?', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $propDmg ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, !$propDmg ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(3);

        Fpdf::Cell(60, 5, 'Police Contacted?', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $policeCont ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, !$policeCont ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(3);

        Fpdf::Cell(70, 10, 'Details of Damage (if Applicable):', 0, 1, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, $whatHappend->details_of_damage ?? '', 1);
        Fpdf::Ln(1);

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(60, 5, 'Incident reported to the Line Manager?', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $lineRep ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, !$lineRep ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(3);

        Fpdf::Cell(70, 5, "Manager's name:", 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(120, 5, $whatHappend->manager_name ?? '', 1, 1, 'L');
        Fpdf::Ln(3);

        // ── Part 6: Manager's report ───────────────────────────────────────────
        Fpdf::Ln(6);
        Fpdf::SetFont('Arial', 'B', 15);
        Fpdf::Cell(190, 5, "Part 6: Manager's report", 0, 1, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(190, 5, 'This is to be completed by team leader/ house supervisor/ line manager', 0, 1, 'L');
        Fpdf::Ln(3);

        Fpdf::Cell(20, 5, 'Name:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(90, 5, $manager->report_manager_name ?? '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(30, 5, 'Position:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(50, 5, $manager->report_manager_position ?? '', 1, 1, 'L');
        Fpdf::Ln(6);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::MultiCell(0, 4, 'Immediate action taken to ensure the health and safety and wellbeing of person involved in the Incident:');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, iconv('UTF-8', 'ASCII//TRANSLIT', $manager->immediate_action_taken ?? ''), 1);
        Fpdf::Ln(3);

        $familyN  = $manager->family_notified ?? 0;
        $investPC = $manager->investigation_possible_causes ?? 0;
        $investAC = $manager->investigation_action_completed ?? 0;
        $repInc   = $manager->reportable_incident ?? 0;

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(70, 5, 'Family, career, guardian notified?', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $familyN == 1 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $familyN == 0 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(3);

        Fpdf::Cell(70, 5, 'Investigation Undertaken into possible causes? ', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $investPC == 1 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $investPC == 0 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(6);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::MultiCell(0, 4, 'Investigation record of what happened?');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, iconv('UTF-8', 'ASCII//TRANSLIT', $manager->investigation_record ?? ''), 1);
        Fpdf::Ln(6);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::MultiCell(0, 4, 'Investigation Finding:');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, iconv('UTF-8', 'ASCII//TRANSLIT', $manager->investigation_finding ?? ''), 1);
        Fpdf::Ln(6);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::MultiCell(0, 4, 'Outcome/action Following to mitigate further incident:');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, iconv('UTF-8', 'ASCII//TRANSLIT', $manager->outcome_incident ?? ''), 1);
        Fpdf::Ln(3);

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(60, 5, 'Investigation Action Completed? ', 0, 0, 'L');
        Fpdf::Cell(80, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $investAC == 1 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $investAC == 0 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(6);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::MultiCell(0, 4, 'Investigation action Date Completed:');
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, iconv('UTF-8', 'ASCII//TRANSLIT', $manager->informed_date ?? ''), 1);
        Fpdf::Ln(6);

        Fpdf::SetFont('Arial', 'B', 12);
        Fpdf::MultiCell(0, 4, "Participant/representative's feedback/comment:");
        Fpdf::Ln(1);
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::MultiCell(0, 5, iconv('UTF-8', 'ASCII//TRANSLIT', $manager->participant_feedback ?? ''), 1);
        Fpdf::Ln(3);

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(60, 5, 'Is this reportable Incident? ', 0, 0, 'L');
        Fpdf::Cell(80, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $repInc == 1 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'Yes', 0, 0, 'L');
        Fpdf::Cell(20, 5, '', 0, 0, 'L');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 5, $repInc == 0 ? chr(52) : '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(10, 5, 'No', 0, 1, 'L');
        Fpdf::Ln(3);

        // ── Signatures ─────────────────────────────────────────────────────────
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(40, 10, 'Signature of Reporter:', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'I', 14);
        Fpdf::Cell(70, 10, $whatHappend->reporter_signature ?? '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(30, 10, 'Date:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(50, 10, $whatHappend->date ?? '', 1, 1, 'L');

        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(40, 10, 'Signature of Manager:', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'I', 14);
        Fpdf::Cell(70, 10, $incident->sign_box ?? '', 1, 0, 'L');
        Fpdf::SetFont('Arial', 'B', 10);
        Fpdf::Cell(30, 10, 'Date:', 1, 0, 'L');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(50, 10, $incident->manager_sign_date ?? '', 1, 1, 'L');
        Fpdf::Ln(8);

        // ── Output ─────────────────────────────────────────────────────────────
        $pdf = Fpdf::Output('InfiniteAbility.pdf', 'S');

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="InfiniteAbility.pdf"',
        ]);
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

            ActivityLog::record(
                'incident.submitted',
                'Incident report submitted (Reporter: ' . $validated['reporter_name'] . ', City: ' . $validated['city'] . ')',
                $request->ip()
            );

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
        $reporter     = ReporterDetail::findOrFail($id);
        $incident     = IncidentDetail::where('r_id', $reporter->id)->first();
        $incidentType = IncidentType::where('r_id', $reporter->id)->first();
        $participant  = ParticipantsDetail::where('r_id', $reporter->id)->first();
        $staff        = StaffCarer::where('r_id', $reporter->id)->first();
        $whatHappend  = WhatHappend::where('r_id', $reporter->id)->first();
        $manager      = ManagerReport::where('r_id', $reporter->id)->first();

        return view('pages.incident-show', compact(
            'reporter', 'incident', 'incidentType', 'participant', 'staff', 'whatHappend', 'manager'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reporter = ReporterDetail::findOrFail($id);
        $incident = IncidentDetail::where('r_id', $reporter->id)->first();
        $cities   = config('settings.city_name', []);

        return view('pages.incident-edit', compact('reporter', 'incident', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reporter = ReporterDetail::findOrFail($id);

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'contact'        => ['required', 'string', 'max:30'],
            'ir_number'      => ['nullable', 'string', 'max:100'],
            'position_title' => ['nullable', 'string', 'max:255'],
            'city'           => ['nullable'],
            'completed'      => ['boolean'],
            'doi'            => ['nullable', 'date'],
            'toi'            => ['nullable'],
            'address'        => ['nullable', 'string', 'max:500'],
            'incident_background' => ['nullable', 'string'],
        ]);

        $reporter->update([
            'name'           => $validated['name'],
            'contact'        => $validated['contact'],
            'ir_number'      => $validated['ir_number'] ?? null,
            'position_title' => $validated['position_title'] ?? null,
            'city'           => $validated['city'] ?? null,
            'completed'      => $request->boolean('completed'),
        ]);

        $incident = IncidentDetail::where('r_id', $reporter->id)->first();
        if ($incident) {
            $incident->update([
                'doi'                => $validated['doi'] ?? null,
                'toi'                => $validated['toi'] ?? null,
                'address'            => $validated['address'] ?? null,
                'incident_background'=> $validated['incident_background'] ?? null,
            ]);
        }

        ActivityLog::record(
            'incident.updated',
            'Incident report updated (Reporter: ' . $validated['name'] . ', ID: ' . $reporter->id . ')',
            $request->ip()
        );

        return redirect()
            ->route('forms.incident.index')
            ->with('success', 'Incident report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reporter = ReporterDetail::findOrFail($id);

        IncidentDetail::where('r_id', $reporter->id)->delete();
        IncidentType::where('r_id', $reporter->id)->delete();
        ParticipantsDetail::where('r_id', $reporter->id)->delete();
        StaffCarer::where('r_id', $reporter->id)->delete();
        WhatHappend::where('r_id', $reporter->id)->delete();
        ManagerReport::where('r_id', $reporter->id)->delete();
        $reporter->delete();

        return redirect()->route('forms.incident.index')->with('success', 'Incident report deleted.');
    }
}
