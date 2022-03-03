<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
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
        // $hasil = DB::select('select * from tugas left join milestone on tugas.id_milestone = milestone.id_milestone left join status on tugas.id_status = status.id_status left join kategori on tugas.id_kategori = kategori.id_kategori left join karyawan on tugas.id_karyawan = karyawan.id_karyawan');
        $limit = intval(\request()->input('limit'));
        if(request('query')){
            $hasil = DB::table('tugas')
            ->leftJoin('milestone', 'tugas.id_milestone', '=', 'milestone.id_milestone')
            ->leftJoin('status', 'tugas.id_status', '=', 'status.id_status')
            ->leftJoin('kategori', 'tugas.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('karyawan', 'tugas.id_karyawan', '=', 'karyawan.id_karyawan')
            ->where('milestone.nama_milestone', 'LIKE', '%' . request('query') . '%')
            ->orWhere('nama_tugas', '=', request('query'))
            ->orderBy('tgl_mulai_tugas', 'DESC')
            ->paginate($limit);
            // $hasil = DB::select('select * from tugas left join milestone on tugas.id_milestone = milestone.id_milestone left join status on tugas.id_status = status.id_status left join kategori on tugas.id_kategori = kategori.id_kategori left join karyawan on tugas.id_karyawan = karyawan.id_karyawan where id_milestone LIKE '%' '.request('query').' '%' ');
        }else{
            $hasil = DB::table('tugas')
            ->leftJoin('milestone', 'tugas.id_milestone', '=', 'milestone.id_milestone')
            ->leftJoin('status', 'tugas.id_status', '=', 'status.id_status')
            ->leftJoin('kategori', 'tugas.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('karyawan', 'tugas.id_karyawan', '=', 'karyawan.id_karyawan')
            ->orderBy('tgl_mulai_tugas', 'DESC')
            ->paginate($limit);
        }
        
        return response()->json($hasil);
    }

    public function store(Request $request)
    {
       $add = Tugas::create($request->all());

        return response()->json($add);
    }

    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'nama_tugas' => 'required',
            'keterangan_tugas' => 'required',
            'tgl_mulai_tugas' => 'required',
            'tgl_selesai_tugas' => 'required',
            'id_status' => 'required',
            'id_milestone' => 'required',
            'id_karyawan' => 'required',
            'id_kategori' => 'required'
        ]);

        $tgs = Tugas::find($id);
        $data = $request->only($tgs->getFillable());
        $tgs->id_status = $data['id_status'];
        $tgs->id_milestone = $data['id_milestone'];
        $tgs->id_karyawan = $data['id_karyawan'];
        $tgs->id_kategori = $data['id_kategori'];
        $tgs->nama_tugas = $data['nama_tugas'];
        $tgs->keterangan_tugas = $data['keterangan_tugas'];
        $tgs->tgl_mulai_tugas = $data['tgl_mulai_tugas'];
        $tgs->tgl_selesai_tugas = $data['tgl_selesai_tugas'];
        $tgs->save();

        return response()->json($tgs);
    }

    public function destroy($id)
    {
        $hapus = Tugas::destroy($id);
        return response()->json($hapus);
    }

    public function pilihProyek(){
        $hasil = [];
        $proyek = DB::select('select * from proyek where id_proyek = ?', [request()->input('cari')]);
        if(!empty($proyek)){
            foreach($proyek as $p){
                $pr = [
                    'nama_proyek' => $p->nama_proyek
                ];
                $mlst = DB::select('select * from milestone where id_proyek = ?', [$p->id_proyek]);
                if(!empty($mlst)){
                    foreach($mlst as $t){
                        if('id_milestone' == $t->id_milestone){

                        }else{
                            $pr['mlst'][] = [
                                'id_milestone' => $t->id_milestone,
                                'nama_milestone' => $t->nama_milestone,
                            ];
                        }
                    }
                }
                $hasil[] = $pr;
            }
        }
        else{
            $mi = [
                'nama_milestone' => 'Tidak Ada Proyek Yang Dipilih'
            ];
            $hasil[] = $mi;
        }
        return response()->json($hasil);
    }

    public function GantChart(){
        $hasil = [];
        $milestone = DB::select('select * from milestone where id_milestone = ?', [request()->input('query')]);
        if(!empty($milestone)){
            foreach($milestone as $m){
                $mi = [
                    'nama_milestone' => $m->nama_milestone,
                    'task' => []
                ];
                $task = DB::select('select * from tugas where id_milestone = ?', [$m->id_milestone]);
                if(!empty($task)){
                    foreach($task as $t){
                        $mi['task'][] = [
                            'nama_tugas' => $t->nama_tugas,
                            'tgl_mulai_tugas' => $t->tgl_mulai_tugas,
                            'tgl_selesai_tugas' => $t->tgl_selesai_tugas,
                        ];
                    }
                }
                $hasil[] = $mi;
            }
        }
        else{
            $mi = [
                'nama_milestone' => 'Tidak Ada Milestone Yang Dipilih'
            ];
            
            $hasil[] = $mi;
        }
        return response()->json($hasil);
    }
}
