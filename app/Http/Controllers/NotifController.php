<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\ElseIf_;

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
        $output = [];
        $proyek = DB::select('select * from tugas left join karyawan on tugas.id_karyawan = karyawan.id_karyawan');
        if(!empty($proyek)){
            foreach ($proyek as $a) {
                $data = [
                    'nama_tugas' => $a->nama_tugas,
                    'tgl_selesai_tugas' => $a->tgl_selesai_tugas,
                    'nama_karyawan' => $a->nama_karyawan,
                    'notification' => []
                ];
                $tgl_selesai = date('Y-m-d', strtotime($a->tgl_selesai_tugas));
                $now = date('Y-m-d', strtotime("now"));
                $selisih = date('Y-m-d', strtotime('-7 days', strtotime($tgl_selesai)));
                $h1 = date('Y-m-d', strtotime('-1 days', strtotime($tgl_selesai)));
                // $diff = $now - $selisih;
                // $perbedaan = floor($diff / (60 * 60 * 24)) . ' Hari';
                $dStart = new DateTime($now);
                $dEnd = new DateTime($tgl_selesai);
                $dDiff = $dStart->diff($dEnd);
                $x = $dDiff->d;
                if (strtotime($now) < strtotime($tgl_selesai)) {
                    if( $x <= 7 ){
                        $hasil = [
                            'tgl_selesai' => $tgl_selesai,
                            'tgl_sekarang' => $now,
                            'h-7' => $selisih,
                            'h-1' => $h1,
                            'perbedaan' => $x,
                            'nama_tugas' => $a->nama_tugas,
                            'pesan' => $a->nama_tugas . " Kurang " .$x. " Hari Deadline Tugas Dengan Penanggung Jawab " .$a->nama_karyawan. " !",
                        ];
                        $output[] = $hasil;
                    }
                }
                else if (strtotime($now) == strtotime($tgl_selesai)) {
                    $hasil = [
                        'tgl_selesai' => $tgl_selesai,
                        'tgl_sekarang' => $now,
                        'h-7' => $selisih,
                        'h-1' => $h1,
                        'perbedaan' => $x,
                        'nama_tugas' => $a->nama_tugas,
                        'pesan' => $a->nama_tugas . " Hari Ini Deadline Tugas Dengan Penanggung Jawab " .$a->nama_karyawan. " !",
                    ];
                    $output[] = $hasil;
                }
            }
        }
        return response()->json($output);
    }
}
