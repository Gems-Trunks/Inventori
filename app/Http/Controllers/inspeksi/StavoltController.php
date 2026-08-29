<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\StavoltModel;
use App\Services\ApprovalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use ZipArchive;

class StavoltController extends Controller
{
    public function __construct(protected ApprovalService $approvalService)
    {
    }

    public function index(Request $request)
    {
        $stavolts = $this->filteredQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('inspeksi.stavolt.index', [
            'stavolts' => $stavolts,
            'isGroupLeader' => $request->user()->jabatan === 'GL',
        ]);
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
        if (!$this->approvalService->canUpdate($stavolt)) {
            return redirect()->route('inspeksi.stavolt.index')
                ->with('error', 'Inspeksi yang sudah di-approve tidak dapat diubah.');
        }

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

    public function pdf(StavoltModel $stavolt)
    {
        return Pdf::loadView('pdf.inspeksi_stavolt', compact('stavolt'))
            ->setPaper('A4', 'portrait')
            ->stream("Checklist-Inspeksi-Stavolt-{$stavolt->nomor_aset}.pdf");
    }

    public function approve(Request $request, StavoltModel $stavolt)
    {
        $result = $this->approvalService->approve($request, $stavolt);

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

        return redirect()->route('inspeksi.stavolt.index', $request->only('search'))
            ->with($result['type'], $result['message']);
    }

    public function downloadApproved(Request $request)
    {
        $inspections = $this->filteredQuery($request)->whereNotNull('approved_at')->latest()->get();
        if ($inspections->isEmpty()) {
            return back()->with('error', 'Belum ada inspeksi approved untuk diunduh.');
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'stavolt-approved-');
        $zipPath = $temporaryFile . '.zip';
        @unlink($temporaryFile);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat arsip PDF.');
        }

        foreach ($inspections as $inspection) {
            $pdf = Pdf::loadView('pdf.inspeksi_stavolt', ['stavolt' => $inspection])
                ->setPaper('A4', 'portrait')
                ->output();
            $zip->addFromString("Checklist-Stavolt-{$inspection->nomor_aset}.pdf", $pdf);
        }
        $zip->close();

        return response()->download($zipPath, 'Inspeksi-Stavolt-Approved.zip')->deleteFileAfterSend(true);
    }

    private function filteredQuery(Request $request)
    {
        return StavoltModel::query()->when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('nomor_aset', 'like', "%{$request->search}%")
                    ->orWhere('merek', 'like', "%{$request->search}%")
                    ->orWhere('type', 'like', "%{$request->search}%")
                    ->orWhere('sn', 'like', "%{$request->search}%")
                    ->orWhere('departemen', 'like', "%{$request->search}%");
            });
        });
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
