@extends('base')
@section('title','Pekerjaan')
@section('menupekerjaan', 'underline decoration-4 underline-offset-7')

@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Pekerjaan</h1>

        <div class="mx-auto max-w-screen-xl">

            {{-- AREA NOTIFIKASI (Diselipkan di sini agar layout tidak rusak) --}}
            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-700 border border-green-200">
                    <b>Berhasil!</b> {{ session('success') }}
                </div>
            @endif

            @if(session('danger'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-red-700 border border-red-200">
                    <b>Dihapus!</b> {{ session('danger') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-md bg-red-50 p-4 text-red-700 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- BATAS NOTIFIKASI --}}

            {{-- Layout Tombol & Search (Sesuai kode awalmu) --}}
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('pekerjaan.add') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                    Tambah Data
                </a>
                <form class="flex w-full max-w-sm gap-2" autocomplete="off">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Masukkan kata kunci..." class="w-full rounded-md border px-3 py-2 text-sm">
                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 cursor-pointer">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Tabel Data (Layout awal, Logic baru) --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-x divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700" width="1">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama Pekerjaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Jumlah Pegawai</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700" width="1">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($data as $k => $d)
                        <tr class="hover:bg-gray-50">
                            {{-- LOGIC: Nomor urut halaman --}}
                            <td class="px-4 py-3">{{ $data->firstItem() + $k }}</td>

                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->deskripsi }}</td>

                            {{-- LOGIC: Jumlah Pegawai (Task 12) --}}
                            <td class="px-4 py-3 text-gray-600">{{ $d->pegawai_count }} Orang</td>

                            <td class="px-4 py-3 text-center text-gray-600">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="{{ route('pekerjaan.edit', ['id' => $d->id]) }}" class="cursor-pointer rounded-l-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('pekerjaan.destroy', ['id' => $d->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer rounded-r-md border border-l-0 border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                Data pekerjaan kosong.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- LOGIC: Pagination (Task 11) --}}
            <div class="mt-4">
                {{ $data->links() }}
            </div>

        </div>
    </section>
@endsection
