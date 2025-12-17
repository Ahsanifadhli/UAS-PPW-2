<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index() {
        // 1. DATA GENDER (Pie Chart)
        $genderStats = Pegawai::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');


        $maleCount   = $genderStats['male'] ?? 0;
        $femaleCount = $genderStats['female'] ?? 0;


        // 2. DATA TOP 5 PEKERJAAN (Bar Chart)
        $topPekerjaan = Pekerjaan::withCount('pegawai')
            ->orderBy('pegawai_count', 'desc') // Urutkan dari terbanyak
            ->take(5)                          // Ambil 5 saja
            ->get();

        $jobLabels = $topPekerjaan->pluck('nama');
        $jobTotals = $topPekerjaan->pluck('pegawai_count');

        return view('index', compact(
            'maleCount',
            'femaleCount',
            'jobLabels',
            'jobTotals'
        ));
    }
}
