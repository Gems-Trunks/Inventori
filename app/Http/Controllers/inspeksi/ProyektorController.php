<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\ProyektorModel;
use App\Services\ApprovalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use ZipArchive;

class ProyektorController extends Controller
{
    public function __construct(protected ApprovalService $approvalService)
    {
    }

    public function index(Request $request)
    {
        $proyektors = $this->filteredQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('inspeksi.proyektor.index', [
            'proyektors' => $proyektors,
            'isGroupLeader' => $request->user()->jabatan === 'GL',
        ]);
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
        if (!$this->approvalService->canUpdate($proyektor)) {
            return redirect()->route('inspeksi.proyektor.index')
                ->with('error', 'Inspeksi yang sudah di-approve tidak dapat diubah.');
        }

        $proyektor->update($this->validateRequest($request));

        return redirect()->route('inspeksi.proyektor.index')->with('success', 'Data inspeksi proyektor berhasil diperbarui.');
    }

    public function destroy(ProyektorModel $proyektor)
    {
        $proyektor->delete();

        return redirect()->route('inspeksi.proyektor.index')->with('success', 'Data inspeksi proyektor berhasil dihapus.');
    }

    public function pdf(ProyektorModel $proyektor)
    {
        return Pdf::loadView('pdf.inspeksi_proyektor', compact('proyektor'))
            ->setPaper('A4', 'portrait')
            ->stream("Checklist-Inspeksi-Proyektor-{$proyektor->nomor_aset}.pdf");
    }

    public function approve(Request $request, ProyektorModel $proyektor)
    {
        $result = $this->approvalService->approve($request, $proyektor);

        if (!$result['success']) {
            return back()->with($result['type'], $result['message']);
        }

        return back()->with($result['type'], $result['message']);
    }

    public function approveAll(Request $request)
    {
        $result = $this->approvalService->approveMultiple(
            $request,
            $this->filteredQuery($request)
        );

        if (!$result['success']) {
            return back()->with($result['type'], $result['message']);
        }

        return redirect()->route('inspeksi.proyektor.index', $request->only('search'))
            ->with($result['type'], $result['message']);
    }

    public function downloadApproved(Request $request)
    {
        $inspections = $this->filteredQuery($request)->whereNotNull('approved_at')->latest()->get();
        if ($inspections->isEmpty()) {
            return back()->with('error', 'Belum ada inspeksi approved untuk diunduh.');
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'proyektor-approved-');
        $zipPath = $temporaryFile . '.zip';
        @unlink($temporaryFile);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat arsip PDF.');
        }

        foreach ($inspections as $inspection) {
            $pdf = Pdf::loadView('pdf.inspeksi_proyektor', ['proyektor' => $inspection])
                ->setPaper('A4', 'portrait')
                ->output();
            $zip->addFromString("Checklist-Proyektor-{$inspection->nomor_aset}.pdf", $pdf);
        }
        $zip->close();

        return response()->download($zipPath, 'Inspeksi-Proyektor-Approved.zip')->deleteFileAfterSend(true);
    }

    private function filteredQuery(Request $request)
    {
        return ProyektorModel::query()->when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('nomor_aset', 'like', "%{$request->search}%")
                    ->orWhere('merek', 'like', "%{$request->search}%")
                    ->orWhere('type', 'like', "%{$request->search}%")
                    ->orWhere('sn', 'like', "%{$request->search}%")
                    ->orWhere('departemen', 'like', "%{$request->search}%");
            });
        });
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
