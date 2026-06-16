<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentUsers = User::with('role')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.dashboard', compact('recentUsers'));
    }
}
