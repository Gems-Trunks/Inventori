<?php

namespace App\Http\Controllers\inspeksi;

use App\Http\Controllers\Controller;
use App\Models\inspeksi\OfaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use ZipArchive;

class OfaController extends Controller
{
    public const CHECKLIST_SECTIONS = [
        'A. MAIN MODUL' => [
            'Letak modul sesuai lokasi yang disepakati',
            'Bracket / baut pengunci',
            'Led indicator (merah, kuning)',
            'Port WLAN',
            'Konektor input',
            'Cooling perangkat',
            'Box / cover main modul',
        ],
        'B. LAYAR DISPLAY' => [
            'Pemasangan sesuai lokasi yang disepakati',
            'Bracket / baut pengunci',
            'Kondisi layar',
            'Kabel charger / input power',
            'Input power DC in',
        ],
        'C. OTHER' => [
            'Sambungan kabel',
            'Kabel komunikasi data (PLM/TELEMETRY)',
            'Antena LTE & GPS',
            'Bracket & baut antenna',
            'Push to MQTT server',
            'Koneksi WiFi konfigurasi',
            'Kabel terconduit / terproteksi',
        ],
    ];

    public function index(Request $request)
    {
        $ofas = $this->filteredQuery($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('Inspeksi.ofa.index', [
            'ofas' => $ofas,
            'isGroupLeader' => $request->user()->jabatan === 'GL',
        ]);
    }

    public function create()
    {
        return view('Inspeksi.ofa.create', $this->formData());
    }

    public function store(Request $request)
    {
        OfaModel::create($this->validatedData($request));

        return redirect()->route('inspeksi.ofa.index')->with('success', 'Data inspeksi OFA berhasil disimpan.');
    }

    public function edit(OfaModel $ofa)
    {
        return view('Inspeksi.ofa.edit', array_merge($this->formData(), compact('ofa')));
    }

    public function update(Request $request, OfaModel $ofa)
    {
        if ($ofa->approved_at) {
            return redirect()->route('inspeksi.ofa.index')
                ->with('error', 'Inspeksi yang sudah di-approve tidak dapat diubah.');
        }

        $ofa->update($this->validatedData($request));

        return redirect()->route('inspeksi.ofa.index')->with('success', 'Data inspeksi OFA berhasil diperbarui.');
    }

    public function destroy(OfaModel $ofa)
    {
        $ofa->delete();

        return redirect()->route('inspeksi.ofa.index')->with('success', 'Data inspeksi OFA berhasil dihapus.');
    }

    public function pdf(OfaModel $ofa)
    {
        return Pdf::loadView('pdf.inspeksi_ofa', compact('ofa'))
            ->setPaper('A4', 'portrait')
            ->stream("Checklist-Inspeksi-OFA-{$ofa->code_number_unit}.pdf");
    }

    public function approve(Request $request, OfaModel $ofa)
    {
        $this->ensureGroupLeader($request);

        if ($ofa->approved_at) {
            return back()->with('info', 'Inspeksi ini sudah di-approve.');
        }

        $ofa->update($this->approvalData($request));

        return back()->with('success', 'Inspeksi berhasil di-approve.');
    }

    public function approveAll(Request $request)
    {
        $this->ensureGroupLeader($request);

        $pendingInspections = $this->filteredQuery($request)->whereNull('approved_at')->get();
        foreach ($pendingInspections as $inspection) {
            $inspection->update($this->approvalData($request));
        }

        return redirect()->route('inspeksi.ofa.index', $request->only('search'))
            ->with('success', "{$pendingInspections->count()} inspeksi berhasil di-approve.");
    }

    public function downloadApproved(Request $request)
    {
        $inspections = $this->filteredQuery($request)->whereNotNull('approved_at')->latest()->get();
        if ($inspections->isEmpty()) {
            return back()->with('error', 'Belum ada inspeksi approved untuk diunduh.');
        }

        $temporaryFile = tempnam(sys_get_temp_dir(), 'ofa-approved-');
        $zipPath = $temporaryFile . '.zip';
        @unlink($temporaryFile);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat arsip PDF.');
        }

        foreach ($inspections as $inspection) {
            $pdf = Pdf::loadView('pdf.inspeksi_ofa', ['ofa' => $inspection])
                ->setPaper('A4', 'portrait')
                ->output();
            $zip->addFromString("Checklist-OFA-{$inspection->code_number_unit}.pdf", $pdf);
        }
        $zip->close();

        return response()->download($zipPath, 'Inspeksi-OFA-Approved.zip')->deleteFileAfterSend(true);
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'project_name' => ['nullable', 'string', 'max:255'],
            'version' => ['nullable', 'string', 'max:100'],
            'divisi_department' => ['nullable', 'string', 'max:255'],
            'type_unit' => ['required', 'string', 'max:255'],
            'jobsite' => ['required', 'string', 'max:255'],
            'code_number_unit' => ['required', 'string', 'max:255'],
            'serial_number_modul' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'catatan_tambahan' => ['nullable', 'string'],
            'item_pemeriksaaan' => ['required', 'array', 'min:1'],
            'item_pemeriksaaan.*.nama' => ['required', 'string', 'max:255'],
            'item_pemeriksaaan.*.section' => ['required', 'string', 'max:100'],
            'item_pemeriksaaan.*.status' => ['required', 'in:baik,rusak,na'],
            'item_pemeriksaaan.*.keterangan' => ['nullable', 'string', 'max:1000'],
            'tim_pelaksana' => ['required', 'array', 'min:1'],
            'tim_pelaksana.*.nama' => ['required', 'string', 'max:255'],
            'tim_pelaksana.*.nrp' => ['nullable', 'string', 'max:100'],
            'tim_pelaksana.*.jabatan' => ['nullable', 'string', 'max:255'],
            'tim_pelaksana.*.departemen' => ['nullable', 'string', 'max:255'],
            'tim_pelaksana.*.perusahaan' => ['required', 'string', 'max:255'],
        ]);

        $data['item_pemeriksaaan'] = collect($data['item_pemeriksaaan'])->values()->all();
        $inspector = $request->user();
        $data['diinspeksi_oleh'] = $inspector->nama;

        $inspectorTeam = [
            'nama' => $inspector->nama,
            'nrp' => $inspector->nrp,
            'jabatan' => $inspector->jabatan,
            'departemen' => 'ICT',
            'perusahaan' => 'PT Putra Perkasa Abadi',
        ];
        $otherTeam = collect($data['tim_pelaksana'])
            ->reject(fn ($member) => ($member['nrp'] ?? null) === $inspector->nrp)
            ->values()
            ->all();
        $data['tim_pelaksana'] = array_merge([$inspectorTeam], $otherTeam);

        return $data;
    }

    private function formData(): array
    {
        return [
            'checklistSections' => self::CHECKLIST_SECTIONS,
            'inspector' => auth()->user(),
        ];
    }

    private function filteredQuery(Request $request)
    {
        return OfaModel::query()->when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('project_name', 'like', "%{$request->search}%")
                    ->orWhere('code_number_unit', 'like', "%{$request->search}%")
                    ->orWhere('serial_number_modul', 'like', "%{$request->search}%")
                    ->orWhere('type_unit', 'like', "%{$request->search}%")
                    ->orWhere('jobsite', 'like', "%{$request->search}%");
            });
        });
    }

    private function ensureGroupLeader(Request $request): void
    {
        abort_unless($request->user()->jabatan === 'GL', 403, 'Hanya Group Leader yang dapat melakukan approval.');
    }

    private function approvalData(Request $request): array
    {
        $groupLeader = $request->user();
        $approvedAt = now();

        return [
            'status_approval' => 'approved',
            'diperiksa_oleh' => $groupLeader->nama,
            'approved_by' => $groupLeader->nama,
            'qr_code_persetujuan' => "Nama: {$groupLeader->nama} | NRP: {$groupLeader->nrp} | Jabatan: {$groupLeader->jabatan} | Approved: {$approvedAt->format('d-m-Y H:i')}",
            'approved_at' => $approvedAt,
        ];
    }
}
