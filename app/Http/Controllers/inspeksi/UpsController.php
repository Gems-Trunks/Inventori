<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\UpsModel;
use Illuminate\Http\Request;

class UpsController extends Controller
{
    public function index()
    {
        $ups = UpsModel::latest()->paginate(15);


        return view('Inspeksi.ups.index', compact('ups'));
    }

    public function create()
    {
        return view('Inspeksi.ups.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        UpsModel::create($data);

        return redirect()->route('inspeksi.ups.index')
            ->with('success', 'Data inspeksi UPS berhasil disimpan.');
    }

    public function edit(UpsModel $ups)
    {
        return view('Inspeksi.ups.edit', compact('ups'));
    }

    public function update(Request $request, UpsModel $ups)
    {
        $data = $this->validateRequest($request);

        $ups->update($data);

        return redirect()->route('inspeksi.ups.index')
            ->with('success', 'Data inspeksi UPS berhasil diperbarui.');
    }

    public function destroy(UpsModel $ups)
    {
        $ups->delete();

        return redirect()->route('inspeksi.ups.index')
            ->with('success', 'Data inspeksi UPS berhasil dihapus.');
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
            'indikator_status' => 'nullable|string|max:255',
            'tindakan_indikator_status' => 'nullable|string',
            'fungsi_alarm' => 'nullable|string|max:255',
            'tindakan_fungsi_alarm' => 'nullable|string',
            'respon_kehilangan_daya' => 'nullable|string|max:255',
            'tindakan_respon_kehilangan_daya' => 'nullable|string',
            'fuse' => 'nullable|string|max:255',
            'tindakan_fuse' => 'nullable|string',
            'inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ]);
    }
}
