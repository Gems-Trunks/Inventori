<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CloneInspeksi
{

    public function cloneInpeksi(Request $request, Model $data, string $route)
    {
        try {
            $request->validate([
                'dari_bulan' => 'required|string', // Format dari HTML: YYYY-MM
                'ke_bulan'   => 'required|string', // Format dari HTML: YYYY-MM
            ]);

            // Pecah input dari modal (Contoh: "2026-01" -> 2026 dan 01)
            $sourceParts = explode('-', $request->dari_bulan);
            $yearSource  = $sourceParts[0];
            $monthSource = $sourceParts[1];

            $targetParts = explode('-', $request->ke_bulan);
            $targetYear  = $targetParts[0];
            $targetMonth = $targetParts[1];

            $tableName = (new $data)->getTable();

            // 1. Ambil data asli yang benar-benar berada di bulan & tahun sumber
            $dataAsal = $data->all()->filter(function ($item) use ($yearSource, $monthSource) {
                if (!$item->tanggal_inspeksi) return false;

                // Convert tanggal ke format timestamp PHP
                $timestamp = strtotime($item->tanggal_inspeksi);

                // Ambil tahun dan bulan asli dari record database
                $y = date('Y', $timestamp);
                $m = date('m', $timestamp);

                return $y == $yearSource && $m == $monthSource;
            });

            if ($dataAsal->isEmpty()) {
                return redirect()->back()->with('error', "Tidak ada data inspeksi yang ditemukan pada bulan {$monthSource}-{$yearSource}.");
            }

            $count = 0;

            // 2. Proses Cloning ke urutan standar MySQL (YYYY-MM-DD)
            foreach ($dataAsal as $item) {
                $attributes = $item->getAttributes();

                unset($attributes['id']);
                unset($attributes['created_at']);
                unset($attributes['updated_at']);

                // Bikin hari acak (01 sampai 25)
                $randomDay = str_pad(rand(1, 25), 2, '0', STR_PAD_LEFT);

                // KUNCI PERBAIKAN: Susun sesuai standar MySQL -> YYYY-MM-DD
                // (Tahun - Bulan Tujuan - Hari Acak)
                $attributes['tanggal_inspeksi'] = "{$targetYear}-{$targetMonth}-{$randomDay}";

                \DB::table($tableName)->insert($attributes);
                $count++;
            }

            $namaBulanTujuan = date('F Y', mktime(0, 0, 0, $targetMonth, 1, $targetYear));
            return redirect()->route($route)
                ->with('success', $count . ' Data inspeksi berhasil dicloning ke bulan ' . $namaBulanTujuan);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
