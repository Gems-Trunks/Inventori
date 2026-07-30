<?php

namespace App\Http\Controllers;

use App\Models\BukuTamuModel;
use App\Models\InventarisModel;
use App\Models\inspeksi\MonitorModel;
use App\Models\inspeksi\ProyektorModel;
use App\Models\inspeksi\StavoltModel;
use App\Models\inspeksi\UpsModel;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInventaris = InventarisModel::count();
        $dipinjam = InventarisModel::where('status_peminjaman', 'Belum Dikembalikan')->count();
        $totalTamuHariIni = BukuTamuModel::whereDate('created_at', today())->count();
        $inspeksi = [
            'stavolt' => StavoltModel::count(),
            'ups' => UpsModel::count(),
            'monitor' => MonitorModel::count(),
            'proyektor' => ProyektorModel::count(),
        ];
        $totalInspeksi = array_sum($inspeksi);
        $inventarisTerbaru = InventarisModel::latest()->take(5)->get();
        $tamuTerbaru = BukuTamuModel::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalInventaris', 'dipinjam', 'totalTamuHariIni',
            'inspeksi', 'totalInspeksi', 'inventarisTerbaru', 'tamuTerbaru'
        ));
    }
}
