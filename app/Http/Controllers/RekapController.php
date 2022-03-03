<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
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

    public function pilihTahun(){
        $hasil = [];
        $proyek = DB::select('select * from proyek left join milestone on proyek.id_proyek = milestone.id_milestone where thn_anggaran = ?', [request()->input('cari')]);
        if(!empty($proyek)){
            foreach($proyek as $p){
                $pr = [
                    'nama_proyek' => $p->nama_proyek,
                    'nomor_proyek' => $p->nomor_proyek,
                    'lokasi' => $p->lokasi,
                    'dinas' => $p->dinas,
                    'thn_anggaran' => $p->thn_anggaran,
                    'harga' => (int)$p->harga,
                    'tgl_mulai_proyek' => $p->tgl_mulai_proyek,
                    'tgl_selesai_proyek' => $p->tgl_selesai_proyek,
                    $mlst = [
                        'nama_milestone' => $p->nama_milestone
                    ]
                ];
                $task = DB::select('select * from tugas where id_karyawan = ?', [request()->input('query')]);
                if(!empty($task)){
                    foreach($task as $t){
                        $pr['tgs'][] = [
                            'nama_tugas' => $t->nama_tugas,
                            'tgl_mulai_tugas' => $t->tgl_mulai_tugas,
                            'tgl_selesai_tugas' => $t->tgl_selesai_tugas,
                        ];
                    }
                }
                $hasil[] = $pr;
            }
        }
        else{
            $mi = [
                'nama_milestone' => 'Tahun Rekap Tidak Dipilih'
            ];
            $hasil[] = $mi;
        }
        return response()->json($hasil);
    }

    public function penanggungJawab(){

    }
    
        
}
