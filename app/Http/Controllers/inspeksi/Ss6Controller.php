<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\Ss6Model;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class Ss6Controller extends Controller
{
    //
    public function index(Request $req)
    {
        $cols = ['no_asset', 'no_lambung', 'serial_number', 'diperiksa_oleh', 'diinspeksi_oleh'];

        $query = Ss6Model::query()->search($cols, $req->search);

        $dataSs6 = $query->latest()->paginate(15);

        return view('Inspeksi.ss6.index', compact('dataSs6'));
    }

    public function create()
    {
        return view('Inspeksi.ss6.create');
    }

    public function store(Request $req)
    {
        // 1. Buat array rules dasar terlebih dahulu
        $rules = [
            'no_asset' => 'required|string|max:255',
            'no_lambung' => 'required|string|max:255',
            'tanggal_inspeksi' => 'required|date',
            'serial_number' => 'required|string|max:255',
            'output_powercharge' => 'required|string|max:255',

            'keterangan' => 'nullable|string',
        ];

        // 2. Definisikan field yang ingin di-loop
        $feilds = [
            'kondisi_monitor', 'kondisi_bracket', 'kondisi_car_charger',
            'kondisi_kabel_power', 'kondisi_app_lock', 'software_ppa_teams',
            'kondisi_baterai',
        ];

        // 3. Masukkan rules tambahan secara dinamis lewat loop
        foreach ($feilds as $field) {
            // Ganti 'required|string' di bawah sesuai dengan validasi yang kamu butuhkan (misal: 'required|in:baik,rusak')
            $rules[$field.'_ketersediaan'] = 'required|string';
            $rules[$field.'_kondisi'] = 'required|string';
        }

        // 4. Jalankan validasi menggunakan array rules yang sudah lengkap
        $validated = $req->validate($rules);

        foreach ($feilds as $field) {
            // Gabung menjadi array key-value, lalu di-encode ke JSON string
            $validated[$field] = json_encode([
                'ketersediaan' => $validated[$field.'_ketersediaan'],
                'kondisi' => $validated[$field.'_kondisi'],
            ]);

            unset($validated[$field.'_ketersediaan']);
            unset($validated[$field.'_kondisi']);
        }

        // 5. Tambahkan data user yang login
        $validated['diperiksa_oleh'] = auth()->user()->nama;

        // 6. Simpan ke database
        Ss6Model::create($validated);

        return redirect()
            ->route('inspeksi.ss6.index')
            ->with('success', 'Data inspeksi berhasil disimpan');
    }

    public function edit(Ss6Model $inspeksi)
    {
        return view('Inspeksi.ss6.edit', compact('inspeksi'));
    }

    public function update(Request $req, Ss6Model $inspeksi)
    {
        // 1. Buat array rules dasar terlebih dahulu
        $rules = [
            'no_asset' => 'required|string|max:255',
            'no_lambung' => 'required|string|max:255',
            'tanggal_inspeksi' => 'required|date',
            'serial_number' => 'required|string|max:255',
            'output_powercharge' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            ];

        // 2. Definisikan field yang ingin di-loop
        $feilds = [
            'kondisi_monitor', 'kondisi_bracket', 'kondisi_car_charger',
            'kondisi_kabel_power', 'kondisi_app_lock', 'software_ppa_teams',
            'kondisi_baterai',
        ];

        // 3. Masukkan rules tambahan secara dinamis lewat loop
        foreach ($feilds as $field) {
            // Ganti 'required|string' di bawah sesuai dengan validasi yang kamu butuhkan (misal: 'required|in:baik,rusak')
            $rules[$field.'_ketersediaan'] = 'required|string';
            $rules[$field.'_kondisi'] = 'required|string';
        }

        // 4. Jalankan validasi menggunakan array rules yang sudah lengkap
        $validated = $req->validate($rules);

        foreach ($feilds as $field) {
            // Gabung menjadi array key-value, lalu di-encode ke JSON string
            $validated[$field] = json_encode([
                'ketersediaan' => $validated[$field.'_ketersediaan'],
                'kondisi' => $validated[$field.'_kondisi'],
            ]);

            unset($validated[$field.'_ketersediaan']);
            unset($validated[$field.'_kondisi']);
        }

        $validated['diperiksa_oleh'] = auth()->user()->nama;

        if (auth()->user()->jabatan == 'GL') {
            $validated['dinspeksi_oleh'] = auth()->user()->nama;
        }

        $inspeksi->update($validated);

        return redirect()
            ->route('inspeksi.ss6.index')
            ->with('success', 'Data inspeksi berhasil diperbarui.');
    }

    public function destroy(Ss6Model $inspeksi)
    {
        $inspeksi->delete();

        return redirect()
            ->route('inspeksi.ss6.index')
            ->with('success', 'Data inspeksi berhasil dihapus.');
    }

    public function pdf($id)
    {
        $inspeksi = Ss6Model::findOrFail($id);

        $pdf = PDF::loadView('pdf.inspeksi_ss6', compact('inspeksi'));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream(
            'Form-Inspeksi-Monitor-SS6-'.$inspeksi->no_asset.'.pdf'
        );
    }
}
