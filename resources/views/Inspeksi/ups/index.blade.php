    @extends('layouts.app')
    @section('judul', 'Inspeksi UPS')
    @section('subjudul', 'Indek Inpeksi UPS')

    @section('konten')

        
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <x-counter-badge title='Total Data Inspeksi UPS' bgColor="bg-info-subtle" :counter="$ups->count()"></x-counter-badge>
                {{-- <x-counter-badge title='Total Barang Dipinjam' bgColor="bg-warning-subtle"
                    :counter="$totalBelumDikembalikan"></x-counter-badge>
                <x-counter-badge title='Total Barang Dikembalikan' bgColor="bg-success-subtle"
                    :counter="$totalDikembalikan"></x-counter-badge> --}}


                <div class="d-flex align-items-center gap-2">
                    <x-data-search :action="route('inspeksi.ss6.index')" placeholder="Cari data UPS"></x-data-search>
                    <a class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
                        href="{{ route('inspeksi.ups.create') }}">
                        <i class="bi bi-plus-lg"></i> Tambah Barang
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3 mb-3">
            <a id="export-csv" href="{{ route('inventaris.export') }}"class="btn btn-sm btn-outline-success">
                <i class="bi bi-file-excel me-1" aria-hidden="true"></i>
                Export Excel
            </a>

            {{-- gak kepakek --}}
            {{-- <button id="print-table" type="button" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-printer me-1" aria-hidden="true"></i>
                Print
            </button> --}}
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px" class="text-center">No</th>
                        <th>Nomor Aset</th>
                        <th>Merek</th>
                        <th>Tipe</th>
                        <th>SN</th>
                        <th>Departemen</th>
                        <th>Lokasi</th>
                        <th>Tanggal Inspeksi</th>
                        <th>Inspektor</th>
                        <th>Diketahui Oleh</th>
                        <th style="width: 150px" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ups as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nomor_aset }}</td>
                            <td>{{ $item->merek }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->sn }}</td>
                            <td>{{ $item->departemen }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>
                                {{ $item->tanggal_inspeksi ? \Carbon\Carbon::parse($item->tanggal_inspeksi)->format('d M Y') : '-' }}
                            </td>
                            <td>{{ $item->inspektor }}</td>
                            <td>{{ $item->diketahui_oleh }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm gap-1" role="group">
                                    <a href="{{ route('inspeksi.ups.edit', $item->id) }}"
                                        class="btn btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('inspeksi.ups.destroy', $item->id) }}"
                                        id="form-delete-{{ $item->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deleteConfirm('form-delete-{{ $item->id }}')"
                                            class="btn btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-3">
                                Belum ada data inspeksi UPS.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer text-secondary small">
            {{-- Powered by
            <a href="https://tabulator.info/" target="_blank" rel="noopener">Tabulator</a>
            &mdash; vanilla JS, no jQuery required. --}}
        </div>

    @endsection
