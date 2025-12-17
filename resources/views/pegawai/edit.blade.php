@extends('base')
@section('title', 'Edit Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')

@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Edit Pegawai</h1>

        <div class="mx-auto max-w-screen-xl">
            {{-- Menampilkan Error Validasi --}}
            @if($errors->any())
                <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Perhatikan route menggunakan ID --}}
            <form action="{{ route('pegawai.update', ['id' => $data->id]) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Input Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $data->nama) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>

                {{-- Input Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $data->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                </div>

                {{-- Dropdown Pekerjaan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan / Jabatan</label>
                    <select name="pekerjaan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach($pekerjaan as $p)
                            {{-- Logic Selected: Jika ID pekerjaan sama dengan data pegawai, maka pilih ini --}}
                            <option value="{{ $p->id }}" {{ (old('pekerjaan_id', $data->pekerjaan_id) == $p->id) ? 'selected' : '' }}>
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
                        <option value="male" {{ (old('gender', $data->gender) == 'male') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ (old('gender', $data->gender) == 'female') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    {{-- Tombol Batal/Back --}}
                    <a href="{{ route('pegawai.index') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">Batal</a>

                    <button type="submit" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700 cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
