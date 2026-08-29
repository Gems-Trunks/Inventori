@php
    $items = old(
        'item_pemeriksaan',
        $ofa->item_pemeriksaan ??
            collect($defaultItems)->map(fn($nama) => ['nama' => $nama, 'status' => '', 'keterangan' => ''])->all(),
    );
    $tim = old('tim_pemeriksa', $ofa->tim_pemeriksa ?? [['nama' => '', 'perusahaan' => '']]);
@endphp

<div class="row g-3">
    <div class="col-12">
        <h6 class="text-primary fw-bold border-bottom pb-2">Data Unit</h6>
    </div>
    @foreach (['no_asset' => 'No. Asset', 'no_lambung' => 'No. Lambung', 'jenis_unit' => 'Jenis Unit', 'merek' => 'Merek', 'serial_number' => 'Serial Number'] as $field => $label)
        <div class="col-md-4"><label for="{{ $field }}" class="form-label">{{ $label }}@if ($field === 'no_asset')
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input id="{{ $field }}" name="{{ $field }}"
                class="form-control @error($field) is-invalid @enderror" value="{{ old($field, $ofa->$field ?? '') }}">
            @error($field)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach
    <div class="col-md-4"><label for="tanggal_inspeksi" class="form-label">Tanggal Inspeksi <span
                class="text-danger">*</span></label><input id="tanggal_inspeksi" type="date" name="tanggal_inspeksi"
            class="form-control @error('tanggal_inspeksi') is-invalid @enderror"
            value="{{ old('tanggal_inspeksi', isset($ofa) && $ofa->tanggal_inspeksi ? $ofa->tanggal_inspeksi->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required></div>

    <div class="col-12 mt-4">
        <h6 class="text-primary fw-bold border-bottom pb-2">Item Pemeriksaan</h6>
    </div>
    <div class="col-12 table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th class="text-center">Status</th>
                    <th>Keterangan / Tindakan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="inspection-items">
                @foreach ($items as $index => $item)
                    <tr>
                        <td><input name="item_pemeriksaan[{{ $index }}][nama]" class="form-control"
                                value="{{ $item['nama'] ?? '' }}" required></td>
                        <td><select name="item_pemeriksaan[{{ $index }}][status]" class="form-select" required>
                                <option value="">Pilih status</option>
                                @foreach (['baik' => 'Baik', 'tidak_baik' => 'Tidak Baik', 'tidak_tersedia' => 'Tidak Tersedia'] as $value => $label)
                                    <option value="{{ $value }}" @selected(($item['status'] ?? '') === $value)>
                                        {{ $label }}</option>
                                @endforeach
                            </select></td>
                        <td><input name="item_pemeriksaan[{{ $index }}][keterangan]" class="form-control"
                                value="{{ $item['keterangan'] ?? '' }}" placeholder="Keterangan atau tindakan"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-row"
                                title="Hapus"><i class="bi bi-trash"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table><button type="button" id="add-inspection-item" class="btn btn-sm btn-outline-primary"><i
                class="bi bi-plus-lg"></i> Tambah Item</button>
    </div>

    <div class="col-12 mt-4">
        <h6 class="text-primary fw-bold border-bottom pb-2">Tim Pemeriksa</h6>
    </div>
    <div class="col-12 table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Pemeriksa</th>
                    <th>Perusahaan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="inspection-team">
                @foreach ($tim as $index => $anggota)
                    <tr>
                        <td><input name="tim_pemeriksa[{{ $index }}][nama]" class="form-control"
                                value="{{ $anggota['nama'] ?? '' }}" placeholder="Nama pemeriksa" required></td>
                        <td><input name="tim_pemeriksa[{{ $index }}][perusahaan]" class="form-control"
                                value="{{ $anggota['perusahaan'] ?? '' }}" placeholder="Nama perusahaan" required></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-row"
                                title="Hapus"><i class="bi bi-trash"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table><button type="button" id="add-team-member" class="btn btn-sm btn-outline-primary"><i
                class="bi bi-plus-lg"></i> Tambah Pemeriksa</button>
    </div>

    <div class="col-12"><label for="keterangan" class="form-label">Keterangan Tambahan</label>
        <textarea id="keterangan" name="keterangan" class="form-control" rows="3">{{ old('keterangan', $ofa->keterangan ?? '') }}</textarea>
    </div>
</div>

@push('scripts')
    <script>
        const statusOptions =
            '<option value="">Pilih status</option><option value="baik">Baik</option><option value="tidak_baik">Tidak Baik</option><option value="tidak_tersedia">Tidak Tersedia</option>';
        const addRow = (target, html) => document.querySelector(target).insertAdjacentHTML('beforeend', html);
        document.getElementById('add-inspection-item').addEventListener('click', () => {
            const i = document.querySelectorAll('#inspection-items tr').length;
            addRow('#inspection-items',
                `<tr><td><input name="item_pemeriksaan[${i}][nama]" class="form-control" required></td><td><select name="item_pemeriksaan[${i}][status]" class="form-select" required>${statusOptions}</select></td><td><input name="item_pemeriksaan[${i}][keterangan]" class="form-control"></td><td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-trash"></i></button></td></tr>`
            );
        });
        document.getElementById('add-team-member').addEventListener('click', () => {
            const i = document.querySelectorAll('#inspection-team tr').length;
            addRow('#inspection-team',
                `<tr><td><input name="tim_pemeriksa[${i}][nama]" class="form-control" required></td><td><input name="tim_pemeriksa[${i}][perusahaan]" class="form-control" required></td><td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-row"><i class="bi bi-trash"></i></button></td></tr>`
            );
        });
        document.addEventListener('click', event => {
            if (event.target.closest('.remove-row')) event.target.closest('tr').remove();
        });
    </script>
@endpush
