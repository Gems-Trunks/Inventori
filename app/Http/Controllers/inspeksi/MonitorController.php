<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\MonitorModel;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function index()
    {
        $monitors = MonitorModel::latest()->paginate(15);

        return view('inspeksi.monitor.index', compact('monitors'));
    }

    public function create()
    {
        return view('inspeksi.monitor.create');
    }

    public function store(Request $request)
    {
        MonitorModel::create($this->validateRequest($request));

        return redirect()->route('inspeksi.monitor.index')->with('success', 'Data inspeksi monitor/TV berhasil disimpan.');
    }

    public function edit(MonitorModel $monitor)
    {
        return view('inspeksi.monitor.edit', compact('monitor'));
    }

    public function update(Request $request, MonitorModel $monitor)
    {
        $monitor->update($this->validateRequest($request));

        return redirect()->route('inspeksi.monitor.index')->with('success', 'Data inspeksi monitor/TV berhasil diperbarui.');
    }

    public function destroy(MonitorModel $monitor)
    {
        $monitor->delete();

        return redirect()->route('inspeksi.monitor.index')->with('success', 'Data inspeksi monitor/TV berhasil dihapus.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'nomor_aset' => 'nullable|string|max:255', 'merek' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255', 'sn' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255', 'lokasi' => 'nullable|string|max:255',
            'tanggal_inspeksi' => 'nullable|date', 'keterangan' => 'nullable|string',
            'tampilan_layer' => 'nullable|string|max:255', 'kabel_power' => 'nullable|string|max:255',
            'bracket_dudukan' => 'nullable|string|max:255', 'kebersihan' => 'nullable|string|max:255',
            'stop_kontak' => 'nullable|string|max:255', 'tindakan_tampilan_layer' => 'nullable|string',
            'tindakan_kabel_power' => 'nullable|string', 'tindakan_bracket_dudukan' => 'nullable|string',
            'tindakan_kebersihan' => 'nullable|string', 'tindakan_stop_kontak' => 'nullable|string',
            'inspektor' => 'nullable|string|max:255', 'jabatan_inspektor' => 'nullable|string|max:255',
            'diketahui_oleh' => 'nullable|string|max:255',
        ]);
    }
}
