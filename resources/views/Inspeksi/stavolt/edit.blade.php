@extends('layouts.app')

@section('judul', 'Edit Inspeksi Stavolt')
@section('subjudul', 'Form Ubah Data Inspeksi Stavolt')

@section('konten')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center"><h5 class="mb-0 fw-bold">Ubah Data Inspeksi Stavolt</h5><a href="{{ route('inspeksi.stavolt.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a></div>
        <div class="card-body"><form action="{{ route('inspeksi.stavolt.update', $stavolt) }}" method="POST">@csrf @method('PUT') @include('inspeksi.stavolt._form')<div class="text-end mt-4"><a href="{{ route('inspeksi.stavolt.index') }}" class="btn btn-light me-2">Batal</a><button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Perbarui Data</button></div></form></div>
    </div>
@endsection
