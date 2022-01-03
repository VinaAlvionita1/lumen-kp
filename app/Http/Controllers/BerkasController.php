<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerkasController extends Controller
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
        // $hasil = DB::select('select * from berkas left join milestone on berkas.id_milestone = milestone.id_milestone')
        $limit = intval(\request()->input('limit'));
        $hasil = DB::table('berkas')
        ->leftJoin('milestone', 'berkas.id_milestone', '=', 'milestone.id_milestone')
        ->paginate($limit);
        if(request('query')){
            $hasil = DB::table('berkas')
            ->leftJoin('milestone', 'berkas.id_milestone', '=', 'milestone.id_milestone')
            ->where('milestone.id_milestone', '=', request('query'))
            ->paginate($limit);
        }else{
            $hasil = DB::table('berkas')
            ->leftJoin('milestone', 'berkas.id_milestone', '=', 'milestone.id_milestone')
            ->paginate($limit);
        }
        return response()->json($hasil);
    }

    public function store(Request $request)
    {
        $this -> validate($request, [
            'id_milestone' => 'required',
            'nama_berkas' => 'required',
            'keterangan' => 'required',
            'tgl_upload' => 'required',
        ]);

        if($request->file('file')){
            $name = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('berkas',$name);

            $id_milestone = $request['id_milestone'];
            $nama_berkas = $request['nama_berkas'];
            $keterangan = $request['keterangan'];
            $file = $name;
            $tgl_upload = $request['tgl_upload'];
        }
        $add = Berkas::create([
            'id_milestone' => $id_milestone,
            'nama_berkas' => $nama_berkas,
            'keterangan' => $keterangan,
            'file' => $file,
            'tgl_upload' => $tgl_upload,
        ]);

        return response()->json($add);
    }

    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'id_milestone' => 'required',
            'nama_berkas' => 'required',
            'keterangan' => 'required',
            'tgl_upload' => 'required'
        ]);
        
        $brks = Berkas::find($id);
        $data = $request->only($brks->getFillable());

        if($request->file('file')){
            $name = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('berkas',$name);
            $brks->file = $name;
        }

        $brks->id_milestone = $data['id_milestone'];
        $brks->nama_berkas = $data['nama_berkas'];
        $brks->keterangan = $data['keterangan'];
        $brks->tgl_upload = $data['tgl_upload'];
        $brks->save();

        return response()->json($brks);
    }

    public function destroy($id)
    {
        $hapus = Berkas::destroy($id);
        return response()->json($hapus);
    }
}
