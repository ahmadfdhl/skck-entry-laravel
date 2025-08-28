<?php

namespace App\Http\Controllers;

use App\Models\Skck;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSkck = Skck::count();
        $skckToday = Skck::whereDate('created_at', today())->count();
        $skckThisMonth = Skck::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();
        $totalUsers = User::count();

        // Data for monthly chart (last 6 months)
        $monthlyData = [];
        $monthlyLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->translatedFormat('M Y');
            
            $count = Skck::whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year)
                        ->count();
            
            $monthlyData[] = $count;
        }

        $recentSkck = Skck::latest()
                        ->take(5)
                        ->get();

        return view('dashboard', compact(
            'totalSkck',
            'skckToday',
            'skckThisMonth',
            'totalUsers',
            'monthlyData',
            'monthlyLabels',
            'recentSkck'
        ));
    }
}