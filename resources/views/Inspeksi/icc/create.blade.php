@extends('layouts.app')
@section('judul', 'Tambah Pemeliharaan ICC')
@section('subjudul', 'Isi formulir pemeliharaan perangkat ICC')
@section('konten')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('inspeksi.icc.store') }}" method="POST">@csrf @include('Inspeksi.icc._form_fields')<div
                    class="text-end mt-4"><a href="{{ route('inspeksi.icc.index') }}"
                        class="btn btn-light me-2">Batal</a><button class="btn btn-primary"><i
                            class="bi bi-save me-1"></i>Simpan Data</button></div>
            </form>
        </div>
    </div>
@endsection
