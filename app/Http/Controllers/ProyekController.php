<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // $query = \request()->get('query') ?? '';
        // $proyek = Proyek::where('nama_proyek', 'LIKE', "%{$query}%")->get();
        // $proyek = Proyek::paginate(1);
        

        if(request('query')){
            $proyek = Proyek::where('nama_proyek', 'LIKE', '%' . request('query') . '%')
                        ->orWhere('lokasi', 'LIKE', '%' . request('query') . '%')
                        ->paginate(2);
        }else{
            $proyek = Proyek::paginate(2);
        }
        return response()->json($proyek);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request, [
            'nomor_proyek' => 'required',
            'nama_proyek' => 'required',
            'lokasi' => 'required',
            'dinas' => 'required',
            'thn_anggaran' => 'required',
            'harga' => 'required',
            'tgl_mulai_proyek' => 'required',
            'tgl_selesai_proyek' => 'required'
        ]);

        $proyek = new Proyek();
        $proyek->nomor_proyek = $request['nomor_proyek'];
        $proyek->nama_proyek = $request['nama_proyek'];
        $proyek->lokasi = $request['lokasi'];
        $proyek->dinas = $request['dinas'];
        $proyek->thn_anggaran = $request['thn_anggaran'];        
        $proyek->harga = $request['harga'];
        $proyek->tgl_mulai_proyek = $request['tgl_mulai_proyek'];
        $proyek->tgl_selesai_proyek = $request['tgl_selesai_proyek'];
        $proyek->save();
        $proyek->id_proyek;

        $milestone = new Milestone();
        $milestone->nama_milestone = $proyek->nama_proyek;
        $milestone->id_proyek = $proyek->id_proyek;
        $milestone->save();

        $data = [
            $proyek->save(),
            $milestone->save()
        ];

        // $add = Proyek::create($request->all());
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
       $this -> validate($request, [
            'nomor_proyek' => 'required',
            'nama_proyek' => 'required',
            'lokasi' => 'required',
            'dinas' => 'required',
            'thn_anggaran' => 'required',
            'harga' => 'required',
            'tgl_mulai_proyek' => 'required',
            'tgl_selesai_proyek' => 'required'
        ]);

        $proyek = Proyek::find($id);
        $data = $request->only($proyek->getFillable());
        $proyek->nomor_proyek = $data['nomor_proyek'];
        $proyek->nama_proyek = $data['nama_proyek'];
        $proyek->lokasi = $data['lokasi'];
        $proyek->dinas = $data['dinas'];
        $proyek->thn_anggaran = $data['thn_anggaran'];        
        $proyek->harga = $data['harga'];
        $proyek->tgl_mulai_proyek = $data['tgl_mulai_proyek'];
        $proyek->tgl_selesai_proyek = $data['tgl_selesai_proyek'];
        $proyek->save();

        return response()->json($proyek);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Proyek::destroy($id);
        return response()->json($hapus);
    }
}
