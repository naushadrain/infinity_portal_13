<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PublicComplaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreatePublicComplaintController extends Controller
{
    public function index()
    {
        return view('public-form.add-complaint');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'received_from'  => ['required', 'string', 'max:150'],
            'email'          => ['nullable', 'email', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'complaint'      => ['required', 'string'],
        ]);

        try {
            PublicComplaint::create([
                'name'           => $validated['name'],
                'received_from'  => $validated['received_from'],
                'email'          => $validated['email'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
                'complaint'      => $validated['complaint'],
                'status'         => 'New',
                'submitted_at'   => now()->toDateString(),
            ]);

            ActivityLog::record(
                'public.complaint.submitted',
                'Public complaint submitted (Name: ' . $validated['name'] . ')',
                $request->ip()
            );

            return redirect()->route('complaint.public.create')
                ->with('success', 'Your complaint has been submitted successfully. Thank you.');
        } catch (\Throwable $e) {
            Log::error('Public complaint form submission failed', [
                'message' => $e->getMessage(),
                'ip'      => $request->ip(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit your complaint. Please try again.');
        }
    }
}
