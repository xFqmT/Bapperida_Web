<?php

namespace App\Http\Controllers;

use App\Models\Period;

class DashboardController extends Controller
{
    public function index()
    {
        // Get active periods for dashboard (limited to 5 for dashboard display)
        $activePeriods = Period::where('status', 'active')
            ->orderBy('tanggal_akhir', 'asc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact('activePeriods'));
    }
}
