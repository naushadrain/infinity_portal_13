<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PublicComplaint;
use Illuminate\Http\Request;

class PublicComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PublicComplaint::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('submitted_at', $date);
        }

        $complaints = $query->paginate(15)->withQueryString();

        $statuses = PublicComplaint::select('status')
            ->distinct()
            ->whereNotNull('status')
            ->orderBy('status')
            ->pluck('status');

        return view('pages.complaint-index', compact('complaints', 'statuses'));
    }

    public function export(Request $request)
    {
        $query = PublicComplaint::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->input('date')) {
            $query->whereDate('submitted_at', $date);
        }

        $complaints = $query->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="public-complaints.csv"',
        ];

        $callback = function () use ($complaints) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Sr. No.', 'Submitted', 'Name', 'Received From', 'Email', 'Contact', 'Status']);

            foreach ($complaints as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    ($row->submitted_at ?? $row->created_at)->format('d M Y'),
                    $row->name ?? '',
                    $row->received_from ?? '',
                    $row->email ?? '',
                    $row->contact_number ?? '',
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
        $complaint = PublicComplaint::findOrFail($id);

        return view('pages.complaint-show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $complaint = PublicComplaint::findOrFail($id);

        return view('pages.complaint-edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $complaint = PublicComplaint::findOrFail($id);

        $validated = $request->validate([
            'name'                              => ['required', 'string', 'max:255'],
            'received_from'                     => ['required', 'string', 'max:150'],
            'email'                             => ['nullable', 'email', 'max:255'],
            'contact_number'                    => ['nullable', 'string', 'max:30'],
            'complaint'                         => ['required', 'string'],
            'status'                            => ['required', 'string', 'max:50'],
            'date_closed'                       => ['nullable', 'date'],
            'investigation_undertaken'          => ['nullable', 'boolean'],
            'investigation_record'              => ['nullable', 'string'],
            'investigation_findings'            => ['nullable', 'string'],
            'investigation_actions'             => ['nullable', 'string'],
            'complainant_feedback'              => ['nullable', 'string'],
            'improvement_action_required'       => ['nullable', 'string'],
            'organisational_improvement_actions'=> ['nullable', 'string'],
            'improvement_implemented'           => ['nullable', 'string'],
        ]);

        $complaint->update([
            'name'                              => $validated['name'],
            'received_from'                     => $validated['received_from'],
            'email'                             => $validated['email'] ?? null,
            'contact_number'                    => $validated['contact_number'] ?? null,
            'complaint'                         => $validated['complaint'],
            'status'                            => $validated['status'],
            'date_closed'                       => $validated['date_closed'] ?? null,
            'investigation_undertaken'          => $request->boolean('investigation_undertaken'),
            'investigation_record'              => $validated['investigation_record'] ?? null,
            'investigation_findings'            => $validated['investigation_findings'] ?? null,
            'investigation_actions'             => $validated['investigation_actions'] ?? null,
            'complainant_feedback'               => $validated['complainant_feedback'] ?? null,
            'improvement_action_required'       => $validated['improvement_action_required'] ?? null,
            'organisational_improvement_actions'=> $validated['organisational_improvement_actions'] ?? null,
            'improvement_implemented'           => $validated['improvement_implemented'] ?? null,
        ]);

        ActivityLog::record(
            'complaint.updated',
            'Public complaint updated (Name: ' . $validated['name'] . ', ID: ' . $complaint->id . ')',
            $request->ip()
        );

        return redirect()->route('forms.complaint.index')
            ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            PublicComplaint::findOrFail($id)->delete();

            return redirect()->route('forms.complaint.index')
                ->with('success', 'Record deleted successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->with('error', 'Failed to delete the record. Please try again.');
        }
    }
}
