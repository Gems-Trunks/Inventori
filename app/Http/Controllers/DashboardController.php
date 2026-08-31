<?php

namespace App\Http\Controllers;

use App\Models\BukuTamuModel;
use App\Models\InventarisModel;
use App\Models\inspeksi\MonitorModel;
use App\Models\inspeksi\ProyektorModel;
use App\Models\inspeksi\StavoltModel;
use App\Models\inspeksi\UpsModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Data untuk Admin
        $totalInventaris = null;
        $dipinjam = null;
        $inventarisTerbaru = null;
        
        // Data untuk Admin & Security
        $totalTamuHariIni = null;
        $tamuTerbaru = null;
        
        // Data untuk semua user (Admin, GL, Staff, Non-staff)
        $inspeksi = [
            'stavolt' => StavoltModel::count(),
            'ups' => UpsModel::count(),
            'monitor' => MonitorModel::count(),
            'proyektor' => ProyektorModel::count(),
        ];
        $totalInspeksi = array_sum($inspeksi);

        // Admin dapat melihat semua data
        if ($user->role === 'admin') {
            $totalInventaris = InventarisModel::count();
            $dipinjam = InventarisModel::where('status_peminjaman', 'Belum Dikembalikan')->count();
            $totalTamuHariIni = BukuTamuModel::whereDate('created_at', today())->count();
            $inventarisTerbaru = InventarisModel::latest()->take(5)->get();
            $tamuTerbaru = BukuTamuModel::latest()->take(5)->get();
        }
        // Security hanya melihat data Buku Tamu
        elseif ($user->jabatan === 'security') {
            $totalTamuHariIni = BukuTamuModel::whereDate('created_at', today())->count();
            $tamuTerbaru = BukuTamuModel::latest()->take(5)->get();
        }
        // GL, Staff, Non-staff hanya melihat Inspeksi

        return view('dashboard', compact(
            'totalInventaris', 'dipinjam', 'totalTamuHariIni',
            'inspeksi', 'totalInspeksi', 'inventarisTerbaru', 'tamuTerbaru', 'user'
        ));
    }
}
