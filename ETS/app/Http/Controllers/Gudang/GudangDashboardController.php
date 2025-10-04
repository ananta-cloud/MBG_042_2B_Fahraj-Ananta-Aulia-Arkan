<?php

namespace App\Http\Controllers\Gudang;

use Illuminate\View\View;
use App\Models\Bahan_Baku;
use App\Models\Permintaan;
use Illuminate\Support\Facades\Auth;

class GudangDashboardController
{
    // Display Dashboard untuk role gudang
    public function index(): View
    {
        $user = Auth::user();
        $total_bahan_baku = Bahan_Baku::count();
        $total_permintaan = Permintaan::count();
        $total_kadaluarsa = Bahan_Baku::where('status', 'kadaluarsa')->count();
        $total_segera_kadaluarsa = Bahan_Baku::where('status', 'segera_kadaluarsa')->count();
        $totalPermintaan = Permintaan::where('status', 'menunggu')->count('id');
        $total_habis = Bahan_Baku::where('jumlah', 0)->count();

        return view('gudang.dashboard', compact(
            'user',
            'total_bahan_baku',
            'total_permintaan',
            'total_kadaluarsa',
            'total_segera_kadaluarsa',
            'total_habis',
            'totalPermintaan',
        ));
    }
}
