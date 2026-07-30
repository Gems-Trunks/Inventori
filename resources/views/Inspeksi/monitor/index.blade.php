@extends('layouts.app')
@section('judul', 'Inspeksi Monitor/TV')
@section('subjudul', 'Daftar Data Inspeksi Monitor/TV')
@section('konten')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-3"><x-counter-badge
            title="Total Data Inspeksi Monitor/TV" bgColor="bg-info-subtle" :counter="$monitors->total()" /><a
            class="btn btn-sm btn-outline-success" href="{{ route('inspeksi.monitor.create') }}"><i
                class="bi bi-plus-lg"></i> Tambah Inspeksi</a></div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nomor Aset</th>
                    <th>Merek</th>
                    <th>Tipe</th>
                    <th>SN</th>
                    <th>Departemen</th>
                    <th>Lokasi</th>
                    <th>Tanggal Inspeksi</th>
                    <th>Inspektor</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($monitors as $monitor)
                    <tr>
                        <td class="text-center">{{ $monitors->firstItem() + $loop->index }}</td>
                        <td>{{ $monitor->nomor_aset ?: '-' }}</td>
                        <td>{{ $monitor->merek ?: '-' }}</td>
                        <td>{{ $monitor->type ?: '-' }}</td>
                        <td>{{ $monitor->sn ?: '-' }}</td>
                        <td>{{ $monitor->departemen ?: '-' }}</td>
                        <td>{{ $monitor->lokasi ?: '-' }}</td>
                        <td>{{ $monitor->tanggal_inspeksi ? \Carbon\Carbon::parse($monitor->tanggal_inspeksi)->format('d M Y') : '-' }}
                        </td>
                        <td>{{ $monitor->inspektor ?: '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm gap-1"><a href="{{ route('inspeksi.monitor.edit', $monitor) }}"
                                    class="btn btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('inspeksi.monitor.destroy', $monitor) }}"
                                    id="form-delete-{{ $monitor->id }}" method="POST">@csrf @method('DELETE')<button
                                        type="button" onclick="deleteConfirm('form-delete-{{ $monitor->id }}')"
                                        class="btn btn-danger" title="Hapus"><i class="bi bi-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                @empty <tr>
                        <td colspan="10" class="text-center text-muted py-3">Belum ada data inspeksi Monitor/TV.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($monitors->hasPages())
    <div class="mt-3">{{ $monitors->links() }}</div>@endif
@endsection