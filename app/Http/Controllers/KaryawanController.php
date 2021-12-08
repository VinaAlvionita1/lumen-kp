<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $limit = intval(\request()->input('limit'));
        $hasil = DB::table('karyawan')
        ->leftJoin('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
        ->paginate($limit);
        // $hasil = DB::select('select * from karyawan left join jabatan on karyawan.id_jabatan = jabatan.id_jabatan')
        // ->paginate($limit);
        return response()->json($hasil);
    }

    public function store(Request $request)
    {
       $add = Karyawan::create($request->all());

        return response()->json($add);
    }

    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'id_jabatan' => 'required',
            'nama_karyawan' => 'required',
            'email' => 'required',
            'telp' => 'required'
        ]);

        $kr = Karyawan::find($id);
        $data = $request->only($kr->getFillable());
        $kr->id_jabatan = $data['id_jabatan'];
        $kr->nama_karyawan = $data['nama_karyawan'];
        $kr->email = $data['email'];
        $kr->telp = $data['telp'];
        $kr->save();

        return response()->json($kr);
    }

    public function destroy($id)
    {
        $hapus = Karyawan::destroy($id);
        return response()->json($hapus);
    }
}
