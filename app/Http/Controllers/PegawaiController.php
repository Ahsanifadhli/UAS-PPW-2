<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    // READ (Tampil Data)
    public function index(Request $request) {
        $keyword = $request->get('keyword');


        $data = Pegawai::with('pekerjaan')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%")
                      ->orWhere('gender', 'like', "%{$keyword}%");
            })
            ->paginate(5);

        $data->appends(['keyword' => $keyword]);

        return view('pegawai.index', compact('data'));
    }

    // FORM TAMBAH
    public function add() {

        $pekerjaan = Pekerjaan::all();

        return view('pegawai.add', compact('pekerjaan'));
    }

    // CREATE (Simpan Data Baru)
    public function store(Request $request) {
       $validator = Validator::make($request->all(), [
            'nama'         => 'required|string|max:255',
            'email'        => 'required|email|unique:pegawai,email',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'gender'       => 'required|in:male,female',

            // Validasi Captcha
            'captcha'      => 'required|captcha'
        ], [

            'captcha.captcha' => 'Kode keamanan yang Anda masukkan salah.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Pegawai();
        $data->nama         = $request->nama;
        $data->email        = $request->email;
        $data->pekerjaan_id = $request->pekerjaan_id;
        $data->gender       = $request->gender;
        $data->is_active    = 1;
        $data->save();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data Pegawai berhasil ditambahkan!');
    }

    // FORM EDIT
    public function edit($id) {
        $data = Pegawai::findOrFail($id);
        $pekerjaan = Pekerjaan::all();

        return view('pegawai.edit', compact('data', 'pekerjaan'));
    }

    // UPDATE (Simpan Perubahan)
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama'         => 'required|string|max:255',
            'email'        => 'required|email|unique:pegawai,email,'.$id,
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'gender'       => 'required|in:male,female',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = Pegawai::findOrFail($id);
        $data->nama         = $request->nama;
        $data->email        = $request->email;
        $data->pekerjaan_id = $request->pekerjaan_id;
        $data->gender       = $request->gender;
        $data->save();

        return redirect()->route('pegawai.index')
            ->with('success', 'Data Pegawai berhasil diperbarui!');
    }

    // DELETE (Hapus Data)
    public function destroy($id) {
        $data = Pegawai::findOrFail($id);
        $data->delete();

        return redirect()->route('pegawai.index')
            ->with('danger', 'Data Pegawai berhasil dihapus!');
    }
}
