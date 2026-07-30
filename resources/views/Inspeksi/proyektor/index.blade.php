@extends('layouts.app')
@section('judul', 'Inspeksi Proyektor')
@section('subjudul', 'Daftar Data Inspeksi Proyektor')
@section('konten')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-3"><x-counter-badge
            title="Total Data Inspeksi Proyektor" bgColor="bg-info-subtle" :counter="$proyektors->total()" /><a
            class="btn btn-sm btn-outline-success" href="{{ route('inspeksi.proyektor.create') }}"><i
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
                @forelse ($proyektors as $proyektor)
                    <tr>
                        <td class="text-center">{{ $proyektors->firstItem() + $loop->index }}</td>
                        <td>{{ $proyektor->nomor_aset ?: '-' }}</td>
                        <td>{{ $proyektor->merek ?: '-' }}</td>
                        <td>{{ $proyektor->type ?: '-' }}</td>
                        <td>{{ $proyektor->sn ?: '-' }}</td>
                        <td>{{ $proyektor->departemen ?: '-' }}</td>
                        <td>{{ $proyektor->lokasi ?: '-' }}</td>
                        <td>{{ $proyektor->tanggal_inspeksi ? \Carbon\Carbon::parse($proyektor->tanggal_inspeksi)->format('d M Y') : '-' }}
                        </td>
                        <td>{{ $proyektor->inspektor ?: '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm gap-1"><a
                                    href="{{ route('inspeksi.proyektor.edit', $proyektor) }}" class="btn btn-warning text-white"
                                    title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('inspeksi.proyektor.destroy', $proyektor) }}"
                                    id="form-delete-{{ $proyektor->id }}" method="POST">@csrf @method('DELETE')<button
                                        type="button" onclick="deleteConfirm('form-delete-{{ $proyektor->id }}')"
                                        class="btn btn-danger" title="Hapus"><i class="bi bi-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                @empty <tr>
                        <td colspan="10" class="text-center text-muted py-3">Belum ada data inspeksi proyektor.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($proyektors->hasPages())
    <div class="mt-3">{{ $proyektors->links() }}</div>@endif
@endsection