@extends('layouts.app')

@section('judul', 'Inspeksi Stavolt')
@section('subjudul', 'Daftar Data Inspeksi Stavolt')

@section('konten')
    <div class="card-header">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <x-counter-badge title="Total Data Inspeksi Stavolt" bgColor="bg-info-subtle" :counter="$stavolts->total()" />
            <div class="d-flex align-items-center gap-2">

                <a class="btn btn-sm btn-outline-success" href="{{ route('inspeksi.stavolt.create') }}">
                    <i class="bi bi-plus-lg"></i> Tambah Inspeksi
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
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
                    @forelse ($stavolts as $stavolt)
                        <tr>
                            <td class="text-center">{{ $stavolts->firstItem() + $loop->index }}</td>
                            <td>{{ $stavolt->nomor_aset ?: '-' }}</td>
                            <td>{{ $stavolt->merek ?: '-' }}</td>
                            <td>{{ $stavolt->type ?: '-' }}</td>
                            <td>{{ $stavolt->sn ?: '-' }}</td>
                            <td>{{ $stavolt->departemen ?: '-' }}</td>
                            <td>{{ $stavolt->lokasi ?: '-' }}</td>
                            <td>{{ $stavolt->tanggal_inspeksi ? \Carbon\Carbon::parse($stavolt->tanggal_inspeksi)->format('d M Y') : '-' }}
                            </td>
                            <td>{{ $stavolt->inspektor ?: '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm gap-1">
                                    <a href="{{ route('inspeksi.stavolt.edit', $stavolt) }}"
                                        class="btn btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('inspeksi.stavolt.destroy', $stavolt) }}"
                                        id="form-delete-{{ $stavolt->id }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="deleteConfirm('form-delete-{{ $stavolt->id }}')"
                                            class="btn btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-3">Belum ada data inspeksi Stavolt.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($stavolts->hasPages())
        <div class="card-footer bg-white">{{ $stavolts->links() }}</div>
    @endif
    </div>
@endsection
