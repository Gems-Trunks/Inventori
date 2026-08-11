@extends('layouts.app')

@section('judul', 'Inspeksi Perangkat Monitor SS6')
@section('subjudul', 'Data Inspeksi Monitor SS6')

@section('konten')

   <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-3">

      <x-counter-badge title="Total Data Inspeksi Monitor" bgColor="bg-info-subtle" :counter="$dataSs6->total()" />
      <div class="d-flex align-items-center gap-2">
         <x-data-search :action="route('inspeksi.ss6.index')" placeholder="Cari data Inspeksi"></x-data-search>
         <a class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
            href="{{ route('inspeksi.ss6.create') }}">
            <i class="bi bi-plus-lg"></i> Tambah Inspeksi
         </a>
      </div>

   </div>

   <div class="card shadow-sm">

      <div class="table-responsive">

         <table class="table table-hover table-bordered align-middle mb-0">

            <thead class="table-light">

               <tr>

                  <th width="5%" class="text-center">No</th>
                  <th>No Asset</th>
                  <th>No Lambung</th>
                  <th>Serial Number</th>
                  <th>Tanggal Inspeksi</th>
                  <th>Diinspeksi Oleh</th>
                  <th>Diperiksa Oleh</th>
                  <th width="15%" class="text-center">Aksi</th>

               </tr>

            </thead>

            <tbody>

               @forelse($dataSs6 as $item)

                  <tr>

                     <td class="text-center">
                        {{ $loop->iteration }}
                     </td>

                     <td>{{ $item->no_asset }}</td>

                     <td>{{ $item->no_lambung }}</td>

                     <td>{{ $item->serial_number }}</td>

                     <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_inspeksi)->format('d M Y') }}
                     </td>

                     <td>{{ $item->diinspeksi_oleh }}</td>

                     <td>{{ $item->diperiksa_oleh }}</td>

                     <td class="text-center">

                        <div class="btn-group gap-1">

                           <a href="{{ route('inspeksi.ss6.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                              <i class="bi bi-pencil"></i>
                           </a>

                           <form action="{{ route('inspeksi.ss6.destroy', $item->id) }}" method="POST">

                              @csrf
                              @method('DELETE')

                              <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">

                                 <i class="bi bi-trash"></i>

                              </button>

                           </form>
                           <a href="{{ route('inspeksi.ss6.pdf', $item->id) }}" target="_blank" class="btn btn-danger btn-sm">
                              <i class="bi bi-file-pdf"></i> PDF
                           </a>

                        </div>

                     </td>

                  </tr>

               @empty

                  <tr>

                     <td colspan="8" class="text-center py-4">

                        Belum ada data inspeksi.

                     </td>

                  </tr>

               @endforelse

            </tbody>

         </table>

      </div>

   </div>

   <div class="mt-3">

      {{ $dataSs6->links() }}

   </div>

@endsection