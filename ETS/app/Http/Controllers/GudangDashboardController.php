<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class GudangDashboardController
{

    public function index(): View
    {
        $user = Auth::user();
        return view('gudang.dashboard',[]);
    }
}
