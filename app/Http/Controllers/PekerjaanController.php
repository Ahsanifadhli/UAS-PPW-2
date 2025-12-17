<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\Validator;

class PekerjaanController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->get('keyword');

        // Task 11 & 12 (Pagination & Jumlah Pegawai)
        $data = Pekerjaan::withCount('pegawai')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
            })
            ->paginate(5);

        $data->appends(['keyword' => $keyword]);

        return view('pekerjaan.index', compact('data'));
    }

    public function add() {
        return view('pekerjaan.add');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        // UBAH INI: Gunakan withErrors agar @if($errors->any()) di View jalan
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Pekerjaan();
        $data->nama = $request->nama;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            // Success = Warna Hijau
            return redirect()->route('pekerjaan.index')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->route('pekerjaan.index')->with('success', 'Data tidak tersimpan');
        }
    }

    public function edit(Request $request) {
        // Tetap pakai request->id sesuai kodemu
        $data = Pekerjaan::findOrFail($request->id);
        return view('pekerjaan.edit', compact('data'));
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        // UBAH INI: Gunakan withErrors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tetap pakai request->id sesuai kodemu
        $data = Pekerjaan::findOrFail($request->id);

        $data->nama = $request->nama;
        $data->deskripsi = $request->deskripsi;

        if ($data->save()) {
            // Success = Warna Hijau
            return redirect()->route('pekerjaan.index')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->route('pekerjaan.index')->with('success', 'Data tidak tersimpan');
        }
    }

    public function destroy(Request $request) {
        // Tetap pakai request->id sesuai kodemu
        Pekerjaan::findOrFail($request->id)->delete();

        // UBAH INI: Ganti ke 'danger' agar notifikasi berwarna MERAH
        return redirect()->route('pekerjaan.index')->with('danger', 'Data berhasil dihapus');
    }
}
