@extends('layouts.app')
@section('judul', 'Edit Inspeksi Monitor/TV')
@section('subjudul', 'Form Ubah Data Inspeksi Monitor/TV')
@section('konten')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-bold">Ubah Data Inspeksi Monitor/TV</h5><a href="{{ route('inspeksi.monitor.index') }}"
            class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>
    <form action="{{ route('inspeksi.monitor.update', $monitor) }}" method="POST">@csrf @method('PUT')
        @include('inspeksi.monitor._form')
        <div class="text-end mt-4"><a href="{{ route('inspeksi.monitor.index') }}"
                class="btn btn-light me-2">Batal</a><button type="submit" class="btn btn-primary"><i
                    class="bi bi-save me-1"></i>Perbarui Data</button></div>
    </form>
@endsection