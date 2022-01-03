<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('auth:api');
    }

    public function index()
    {
        $hasil = [];
        $proyek = DB::select('select * from proyek');
        if(!empty($proyek)){
            foreach ($proyek as $a) {
                $data = [
                    'nama_proyekk' => $a->nama_proyek,
                    'tgl_selesai_proyek' => $a->tgl_selesai_proyek
                ];
                $hasil[] = $data;
            }
        }
        return response()->json($hasil);
    }
}
