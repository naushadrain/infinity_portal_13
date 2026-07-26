<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CustomerFeedback;
use Illuminate\Http\Request;

class FeedbackComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CustomerFeedback::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ref_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->input('type')) {
            $query->where('feedback_type', $type);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $complaints = $query->paginate(15)->withQueryString();

        $statuses = CustomerFeedback::select('status')
            ->distinct()
            ->whereNotNull('status')
            ->orderBy('status')
            ->pluck('status');

        return view('pages.complaint-index', compact('complaints', 'statuses'));
    }

    public function export(Request $request)
    {
        $query = CustomerFeedback::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ref_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->input('type')) {
            $query->where('feedback_type', $type);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $complaints = $query->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback-and-complaints.csv"',
        ];

        $callback = function () use ($complaints) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Sr. No.', 'Ref No.', 'Submitted', 'Name', 'Email', 'Type', 'Respondent', 'Status']);

            foreach ($complaints as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row->ref_number ?? '',
                    $row->created_at->format('d M Y'),
                    $row->name ?? '',
                    $row->email ?? '',
                    $row->feedback_type ?? '',
                    $row->respondent_type ?? '',
                    $row->status ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaint = CustomerFeedback::findOrFail($id);

        return view('pages.complaint-show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $complaint = CustomerFeedback::findOrFail($id);

        return view('pages.complaint-edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $complaint = CustomerFeedback::findOrFail($id);

        $validated = $request->validate([
            'city_name'                          => ['nullable', 'string', 'max:255'],
            'name'                               => ['nullable', 'string', 'max:255'],
            'email'                              => ['nullable', 'email', 'max:255'],
            'address'                            => ['nullable', 'string', 'max:255'],
            'wants_interpreter'                  => ['nullable', 'boolean'],
            'interpreter_language'               => ['nullable', 'string', 'max:255'],
            'wants_response'                     => ['nullable', 'boolean'],
            'preferred_contact_method'           => ['nullable', 'in:email,phone,post'],
            'feedback_type'                      => ['nullable', 'in:compliment,complaint,comment'],
            'respondent_type'                    => ['nullable', 'in:participant,family_member,participants_representative,staff_member,staff_on_behalf_of_participant,other'],
            'respondent_type_other'              => ['nullable', 'string', 'max:255'],
            'experience'                         => ['nullable', 'string', 'max:2000'],
            'suggestions'                        => ['nullable', 'string', 'max:2000'],
            'status'                             => ['required', 'string', 'max:50'],
            'date_closed'                        => ['nullable', 'date'],
            'investigation_undertaken'           => ['nullable', 'in:yes,no,na'],
            'investigation_record'               => ['nullable', 'string'],
            'investigation_findings'             => ['nullable', 'string'],
            'investigation_actions'              => ['nullable', 'string'],
            'complainant_feedback'               => ['nullable', 'string'],
            'improvement_action_required'        => ['nullable', 'string'],
            'organisational_improvement_actions' => ['nullable', 'string'],
            'improvement_implemented'            => ['nullable', 'in:yes,no,in_progress'],
            'manager_note'                       => ['nullable', 'string'],
        ]);

        $complaint->update($validated);

        ActivityLog::record(
            'feedback.updated',
            'Feedback/complaint updated (Ref: ' . ($complaint->ref_number ?? $complaint->id) . ')',
            $request->ip()
        );

        return redirect()->route('forms.complaint.index')
            ->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            CustomerFeedback::findOrFail($id)->delete();

            return redirect()->route('forms.complaint.index')
                ->with('success', 'Record deleted successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->with('error', 'Failed to delete the record. Please try again.');
        }
    }
}
