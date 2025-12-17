@extends('base')
@section('title', 'Tambah Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')

@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Tambah Pegawai</h1>

        <div class="mx-auto max-w-screen-xl">
            {{-- Menampilkan Error Validasi (jika ada) --}}
            @if($errors->any())
                <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Input Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Budi Santoso" required>
                </div>

                {{-- Input Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="nama@email.com" required>
                </div>

                {{-- Dropdown Pekerjaan (Relasi) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan / Jabatan</label>
                    <select name="pekerjaan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach($pekerjaan as $p)
                            <option value="{{ $p->id }}" {{ old('pekerjaan_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dropdown Gender --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">-- Pilih Gender --</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- === INPUT CAPTCHA (Task 17) === --}}
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Keamanan</label>

                    <div class="flex items-center gap-3 mb-2">
                        {{-- Gambar Captcha --}}
                        <span class="rounded-md overflow-hidden border border-gray-300">
                            {!! captcha_img('flat') !!}
                        </span>


                        <button type="button" class="text-sm text-blue-600 hover:text-blue-800 underline" onclick="window.location.reload()">
                            Ganti Gambar
                        </button>
                    </div>

                    <input type="text" name="captcha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Masukkan kode di atas" required>
                    <p class="mt-1 text-xs text-gray-500">Buktikan bahwa Anda bukan robot.</p>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="reset" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">Reset</button>
                    <button type="submit" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700 cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
