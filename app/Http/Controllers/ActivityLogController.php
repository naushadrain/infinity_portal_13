<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('event', 'like', "%{$search}%");
            });
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }

        $logs  = $query->paginate(20)->withQueryString();
        $total = ActivityLog::count();

        return view('pages.activity-logs', compact('logs', 'total'));
    }

    public function destroy($id)
    {
        ActivityLog::findOrFail($id)->delete();

        return back()->with('success', 'Log entry deleted.');
    }
}
