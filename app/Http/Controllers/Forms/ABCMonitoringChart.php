<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AbcParticipantDetail;
use Illuminate\Http\Request;

class ABCMonitoringChart extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AbcParticipantDetail::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('participant_name', 'like', "%{$search}%")
                  ->orWhere('participant_address', 'like', "%{$search}%");
            });
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $abcMonitoringCharts = $query->paginate(10)->withQueryString();

        return view('pages.abc-monitoring-chart', compact('abcMonitoringCharts'));
    }

    public function export(Request $request)
    {
        $query = AbcParticipantDetail::latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('participant_name', 'like', "%{$search}%")
                  ->orWhere('participant_address', 'like', "%{$search}%");
            });
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $records = $query->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="abc-monitoring-charts.csv"',
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Sr. No.', 'Participant Name', 'Address', 'Date of Birth', 'Submitted']);

            foreach ($records as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row->participant_name ?? '',
                    $row->participant_address ?? '',
                    $row->participant_date_of_birth
                        ? \Carbon\Carbon::parse($row->participant_date_of_birth)->format('d M Y')
                        : '',
                    $row->created_at->format('d M Y'),
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
        return view('pages.form-abc');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'participant_name'          => 'required|string|max:255',
            'participant_date_of_birth' => 'required|date',
            'participant_address'       => 'required|string|max:500',
            'BSP_practices'             => 'nullable|string',
        ]);

        try {
            AbcParticipantDetail::create([
                'participant_name'          => $request->participant_name,
                'participant_date_of_birth' => $request->participant_date_of_birth,
                'participant_address'       => $request->participant_address,
                'BSP_practices'             => $request->BSP_practices,
            ]);

            ActivityLog::record(
                'abc.submitted',
                'ABC monitoring chart submitted (Participant: ' . $request->participant_name . ')',
                $request->ip()
            );

            return redirect()->route('forms.abc-monitoring-chart.index')
                ->with('success', 'ABC monitoring chart submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit the chart. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $abc = AbcParticipantDetail::findOrFail($id);
        return view('pages.abc-show', compact('abc'));
    }

    public function edit(string $id)
    {
        $abc = AbcParticipantDetail::findOrFail($id);
        return view('pages.abc-edit', compact('abc'));
    }

    public function update(Request $request, string $id)
    {
        $abc = AbcParticipantDetail::findOrFail($id);

        $request->validate([
            'participant_name'          => 'required|string|max:255',
            'participant_date_of_birth' => 'required|date',
            'participant_address'       => 'required|string|max:500',
            'BSP_practices'             => 'nullable|string',
        ]);

        try {
            $abc->update([
                'participant_name'          => $request->participant_name,
                'participant_date_of_birth' => $request->participant_date_of_birth,
                'participant_address'       => $request->participant_address,
                'BSP_practices'             => $request->BSP_practices,
            ]);

            return redirect()->route('forms.abc-monitoring-chart.index')
                ->with('success', 'ABC monitoring chart updated successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update. Please try again.');
        }
    }

    public function destroy(string $id)
    {
        try {
            AbcParticipantDetail::findOrFail($id)->delete();

            return redirect()->route('forms.abc-monitoring-chart.index')
                ->with('success', 'Record deleted successfully.');
        } catch (\Exception) {
            return redirect()->back()
                ->with('error', 'Failed to delete. Please try again.');
        }
    }
}
