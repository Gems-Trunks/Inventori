<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\ProyektorModel;
use Illuminate\Http\Request;

class ProyektorController extends Controller
{
    public function index(Request $request)
    {
        $query = ProyektorModel::query();    

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%'.$search.'%')
                ->orWhere('nrp', 'like', '%'.$search.'%')
                    ->orWhere('nama_perangkat', 'like', '%'.$search.'%')
                    ->orWhere('no_asset', 'like', '%'.$search.'%')
                    ->orWhere('status_peminjaman', 'like', '%'.$search.'%');
            });
        }
                    
        $proyektors = ProyektorModel::latest()->paginate(15);

        return view('inspeksi.proyektor.index', compact('proyektors'));
    }

    public function create()
    {
        return view('inspeksi.proyektor.create');
    }

    public function store(Request $request)
    {
        ProyektorModel::create($this->validateRequest($request));

        return redirect()->route('inspeksi.proyektor.index')->with('success', 'Data inspeksi proyektor berhasil disimpan.');
    }

    public function edit(ProyektorModel $proyektor)
    {
        return view('inspeksi.proyektor.edit', compact('proyektor'));
    }

    public function update(Request $request, ProyektorModel $proyektor)
    {
        $proyektor->update($this->validateRequest($request));

        return redirect()->route('inspeksi.proyektor.index')->with('success', 'Data inspeksi proyektor berhasil diperbarui.');
    }

    public function destroy(ProyektorModel $proyektor)
    {
        $proyektor->delete();

        return redirect()->route('inspeksi.proyektor.index')->with('success', 'Data inspeksi proyektor berhasil dihapus.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'nomor_aset' => 'nullable|string|max:255', 'departemen' => 'nullable|string|max:255',
            'merek' => 'nullable|string|max:255', 'lokasi' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255', 'tanggal_inspeksi' => 'nullable|date',
            'sn' => 'nullable|string|max:255', 'kondisi_casing' => 'nullable|string|max:255',
            'tindakan_kondisi_casing' => 'nullable|string', 'kebersihan' => 'nullable|string|max:255',
            'tindakan_kebersihan' => 'nullable|string', 'kabel_adaptor' => 'nullable|string|max:255',
            'tindakan_kabel_adaptor' => 'nullable|string', 'lensa_proyektor' => 'nullable|string|max:255',
            'tindakan_lensa_proyektor' => 'nullable|string', 'indikator_lampu' => 'nullable|string|max:255',
            'tindakan_indikator_lampu' => 'nullable|string', 'fokus_zoom' => 'nullable|string|max:255',
            'tindakan_fokus_zoom' => 'nullable|string', 'kecerahan_kontras' => 'nullable|string|max:255',
            'tindakan_kecerahan_kontras' => 'nullable|string', 'koneksi_input_hdmi' => 'nullable|string|max:255',
            'koneksi_input_vga' => 'nullable|string|max:255', 'koneksi_input_usb' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string', 'inspektor' => 'nullable|string|max:255',
            'jabatan_inspektor' => 'nullable|string|max:255', 'diketahui_oleh' => 'nullable|string|max:255',
        ]);
    }
}
