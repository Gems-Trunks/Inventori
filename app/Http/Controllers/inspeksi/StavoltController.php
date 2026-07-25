<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\StavoltModel;
use Illuminate\Http\Request;

class StavoltController extends Controller
{
    public function index()
    {
        $stavolts = StavoltModel::latest()->paginate(15);

        return view('inspeksi.stavolt.index', compact('stavolts'));
    }

    public function create()
    {
        return view('inspeksi.stavolt.create');
    }

    public function store(Request $request)
    {
        StavoltModel::create($this->validateRequest($request));

        return redirect()->route('inspeksi.stavolt.index')
            ->with('success', 'Data inspeksi Stavolt berhasil disimpan.');
    }

    public function edit(StavoltModel $stavolt)
    {
        return view('inspeksi.stavolt.edit', compact('stavolt'));
    }

    public function update(Request $request, StavoltModel $stavolt)
    {
        $stavolt->update($this->validateRequest($request));

        return redirect()->route('inspeksi.stavolt.index')
            ->with('success', 'Data inspeksi Stavolt berhasil diperbarui.');
    }

    public function destroy(StavoltModel $stavolt)
    {
        $stavolt->delete();

        return redirect()->route('inspeksi.stavolt.index')
            ->with('success', 'Data inspeksi Stavolt berhasil dihapus.');
    }

    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'nomor_aset' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'casing' => 'nullable|string|max:255',
            'tindakan_casing' => 'nullable|string',
            'kebersihan' => 'nullable|string|max:255',
            'tindakan_kebersihan' => 'nullable|string',
            'kabel_adaptor' => 'nullable|string|max:255',
            'tindakan_kabel_adaptor' => 'nullable|string',
            'tombol_switch' => 'nullable|string|max:255',
            'tindakan_tombol_switch' => 'nullable|string',
            'indikator_voltase' => 'nullable|string|max:255',
            'tindakan_indikator_voltase' => 'nullable|string',
            'respon_perubahan_beban' => 'nullable|string|max:255',
            'tindakan_respon_perubahan_beban' => 'nullable|string',
            'inspektor' => 'nullable|string|max:255',
            'jabatan_inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ]);
    }
}
