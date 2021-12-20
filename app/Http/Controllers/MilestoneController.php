<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MilestoneController extends Controller
{
    public $paginate = 10;
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
        // $hasil = DB::select('select * from milestone left join proyek on milestone.id_proyek = proyek.id_proyek');
        $limit = intval(\request()->input('limit'));
        if(request('query')){
            $hasil = DB::table('milestone')
            ->leftJoin('proyek', 'milestone.id_proyek', '=', 'proyek.id_proyek')
            ->where('nama_milestone', 'LIKE', '%' . request('query') . '%')
            ->paginate($limit);
        }else{
            $hasil = DB::table('milestone')
            ->leftJoin('proyek', 'milestone.id_proyek', '=', 'proyek.id_proyek')
            ->paginate($limit);
        }
        return response()->json($hasil);
    }

    public function tugasGrafik(){
        // $limit = intval(\request()->input('limit'));
        // if(request('query')){
        //     $hasil = DB::table('milestone')
        //     ->leftJoin('proyek', 'milestone.id_proyek', '=', 'proyek.id_proyek')
        //     ->where('proyek.id_proyek', '=', request('query'))
        //     ->paginate($limit);
        // }else{
        //     $hasil = DB::table('milestone')
        //     ->leftJoin('proyek', 'milestone.id_proyek', '=', 'proyek.id_proyek')
        //     ->paginate($limit);
        // }
        // return response()->json($hasil);
        
        $hasil = [];
        $milestone = DB::select('select * from milestone where id_proyek = ?', [request()->input('query')]);
        if(!empty($milestone)){
            foreach($milestone as $m){
                $mi['milestone'] = [
                    'nama_milestone' => $m->nama_milestone,
                    'status' => 0,
                    'task' => []
                ];
            }
            $task = DB::select('select * from tugas where id_milestone = ?', [$m->id_milestone]);
            if(!empty($task)){
                foreach($task as $t){
                    $mi['task'][] = [
                        'nama_tugas' => $t->nama_tugas,
                        'status' => $t->id_status
                    ];
                    $mi['status'] = $t->id_status;
                }
            }
            $hasil[] = $mi;
        }
        return response()->json($hasil);
    }

    public function store(Request $request)
    {
       $add = Milestone::create($request->all());

        return response()->json($add);
    }

    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'id_proyek' => 'required',
            'nama_milestone' => 'required',
        ]);

        $mls = Milestone::find($id);
        $data = $request->only($mls->getFillable());
        $mls->id_proyek = $data['id_proyek'];
        $mls->nama_milestone = $data['nama_milestone'];
        $mls->save();

        return response()->json($mls);
    }

    public function destroy($id)
    {
        $hapus = Milestone::destroy($id);
        return response()->json($hapus);
    }
}
