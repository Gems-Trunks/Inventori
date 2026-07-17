@extends('layouts.app')
@section('judul', 'Dashboard')
@section('konten')

    <div class="row">
        <div class="col-md-12">
            <p>Selamat datang di aplikasi inventaris. Aplikasi ini digunakan untuk:</p>
            <ul>
                <li>Inventaris barang</li>
                <li>Buku tamu</li>
                <li>Form inspeksi</li>
            </ul>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inventaris</h5>
                    <p class="card-text">Kelola data barang, stok, lokasi, dan riwayat inventaris secara terpusat.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Buku Tamu</h5>
                    <p class="card-text">Catat tamu yang datang, data kontak, dan waktu kunjungan dengan mudah.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Inspeksi</h5>
                    <p class="card-text">Isi daftar pengecekan inspeksi untuk memastikan kondisi barang dan fasilitas.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
