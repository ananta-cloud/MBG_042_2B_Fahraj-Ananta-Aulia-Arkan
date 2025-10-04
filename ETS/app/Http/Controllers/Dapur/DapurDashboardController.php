<?php

namespace App\Http\Controllers\Dapur;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Bahan_Baku;

class DapurDashboardController
{
    // Display Dashboard untuk role gudang
    public function index(): View
    {
        $totalBahanBaku = Bahan_Baku::count();
        $user = Auth::user();
        return view('dapur.dashboard',['total_bahan_baku'=>$totalBahanBaku]);
    }
}
