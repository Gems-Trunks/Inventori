    @extends('layouts.app')
    @section('judul', 'Inspeksi UPS')
    @section('subjudul', 'Indek Inpeksi UPS')

    @section('konten')


        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <x-counter-badge title='Total Data Inspeksi UPS' bgColor="bg-info-subtle" :counter="$ups->total()"></x-counter-badge>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <x-data-search :action="route('inspeksi.ups.index')" placeholder="Cari data UPS"></x-data-search>
                    <a href="{{ route('inspeksi.ups.export', request()->only('search')) }}"
                        class="btn btn-sm btn-outline-success"><i class="bi bi-file-excel"></i> Export Excel</a>
                    @if ($isGroupLeader)
                        <form action="{{ route('inspeksi.ups.approve-all') }}" method="POST">@csrf<input type="hidden"
                                name="search" value="{{ request('search') }}"><button class="btn btn-sm btn-success"
                                onclick="return confirm('Approve semua inspeksi yang belum disetujui?')"><i
                                    class="bi bi-check2-all"></i> Approve Semua</button></form>
                    @endif
                    <a href="{{ route('inspeksi.ups.download-approved', request()->only('search')) }}"
                        class="btn btn-sm btn-outline-danger"><i class="bi bi-file-zip"></i> Unduh PDF Approved</a>
                    <a class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
                        href="{{ route('inspeksi.ups.create') }}">
                        <i class="bi bi-plus-lg"></i> Tambah Inspeksi
                    </a>
                </div>
                @if (Auth()->user()->nrp == 250504)
                    <button type="button" class="btn btn-clone btn-modern me-1" data-bs-toggle="modal" data-bs-target="#cloneModal">
                        <i class="fas fa-copy me-1"></i> Clone Inspeksi
                    </button>
                @endif
            </div>
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
                        <th>Status</th>
                        <th>Disetujui Oleh</th>
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
                            <td><span
                                    class="badge {{ $item->approved_at ? 'text-bg-success' : 'text-bg-warning' }}">{{ $item->approved_at ? 'Approved' : 'Menunggu GL' }}</span>
                            </td>
                            <td>{{ $item->approved_by ?: '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm gap-1" role="group">
                                    <a href="{{ route('inspeksi.ups.pdf', $item) }}" class="btn btn-danger" target="_blank"
                                        title="PDF"><i class="bi bi-file-pdf"></i></a>
                                    <a href="{{ route('inspeksi.ups.edit', $item->id) }}"
                                        class="btn btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>

                                    
                                    @if ($isGroupLeader)
                                        <form action="{{ route('inspeksi.ups.approve', $item) }}" method="POST">
                                            @csrf<button class="btn btn-success"
                                                onclick="return confirm('Approve inspeksi ini?')" title="Approve"><i
                                                    class="bi bi-check-lg"></i></button></form>
                                    @endif
                                    <form action="{{ route('inspeksi.ups.destroy', $item->id) }}"
                                        id="form-delete-{{ $item->id }}" method="POST" class="d-inline">@csrf
                                        @method('DELETE')<button type="button"
                                            onclick="deleteConfirm('form-delete-{{ $item->id }}')"
                                            class="btn btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
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

        @if(Auth()->user()->nrp == 250504)
        <x-clone-modal route="{{ route('inspeksi.ups.clone') }}"></x-clone-modal>
        @endif
    @endsection
