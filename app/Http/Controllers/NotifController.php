<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use DateTime;
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
        $output = [];
        $proyek = DB::select('select * from proyek');
        if(!empty($proyek)){
            foreach ($proyek as $a) {
                $data = [
                    'nama_proyekk' => $a->nama_proyek,
                    'tgl_selesai_proyek' => $a->tgl_selesai_proyek,
                    'notification' => []
                ];
                $tgl_selesai = date('Y-m-d', strtotime($a->tgl_selesai_proyek));
                $now = date('Y-m-d', strtotime("now"));
                $selisih = date('Y-m-d', strtotime('-7 days', strtotime($tgl_selesai)));
                $h1 = date('Y-m-d', strtotime('-1 days', strtotime($tgl_selesai)));
                // $diff = $now - $selisih;
                // $perbedaan = floor($diff / (60 * 60 * 24)) . ' Hari';
                $dStart = new DateTime($now);
                $dEnd = new DateTime($selisih);
                $dDiff = $dStart->diff($dEnd);
                $x = $dDiff->d;
                if (strtotime($now) <= strtotime($tgl_selesai)){
                    $s = $now . " lebih kecil dari". $tgl_selesai ;
                    $hasil = [
                        'tgl_selesai' => $tgl_selesai,
                        'tgl_sekarang' => $now,
                        'h-7' => $selisih,
                        'h-1' => $h1,
                        'perbedaan' => $x,
                        'pesan' => $a->nama_proyek . " Kurang " . $x . "Deadline Proyek!",
                    ];
                    $output[] = $hasil;
                }
                // $task = DB::select('select * from notification where id_proyek = ?', [$a->id_proyek]);
                // if( strtotime($now) <= strtotime($tgl_selesai) ){
                //     if( strtotime($tgl_selesai) == strtotime($now)){
                //         // $add = Notification::create([
                //         //     'id_proyek' => $a->id_proyek,
                //         //     'tgl_notif' => $now,
                //         //     'pesan' => $a->nama_proyek . " Hari Ini Deadline Proyek!",
                //         // ]);
                //         $hasil['notification'][] = [
                //             // 'pesan' => $add->pesan
                //             'tgl_selesai' => $tgl_selesai,
                //             'tgl_sekarang' => $now,
                //             'h-7' => $selisih,
                //             'h-1' => $h1,
                //             'perbedaan' => $x,
                //             'pesan' => $a->nama_proyek . " Hari Ini Deadline Proyek!",
                //         ];
                //         $output[] = $hasil;
                //     }
                //     if( strtotime($h1) == strtotime($tgl_selesai)){
                //         // $add = Notification::create([
                //         //     'id_proyek' => $a->id_proyek,
                //         //     'tgl_notif' => $now,
                //         //     'pesan' => $a->nama_proyek . " Besok Deadline Proyek!",
                //         // ]);
                //         $hasil['notification'][] = [
                //             // 'pesan' => $add->pesan
                //             'tgl_selesai' => $tgl_selesai,
                //             'tgl_sekarang' => $now,
                //             'h-7' => $selisih,
                //             'h-1' => $h1,
                //             'perbedaan' => $x,
                //             'pesan' => $a->nama_proyek . " Besok Deadline Proyek!",
                //         ];
                //         $output[] = $hasil;
                //     }
                //     if( strtotime($now) <= strtotime($selisih)){
                //         // $add = Notification::create([
                //         //     'id_proyek' => $a->id_proyek,
                //         //     'tgl_notif' => $now,
                //         //     'pesan' => $a->nama_proyek . " Kurang " . $perbedaan . "Deadline Proyek!",
                //         // ]);
                //         $hasil['notification'][] = [
                //             // 'pesan' => $add->pesan
                //             'tgl_selesai' => $tgl_selesai,
                //             'tgl_sekarang' => $now,
                //             'h-7' => $selisih,
                //             'h-1' => $h1,
                //             'perbedaan' => $x,
                //             'pesan' => $a->nama_proyek . " Kurang " . $x . "Deadline Proyek!",
                //         ];
                //         $output[] = $hasil;
                //     }
                // }
            }
        }
        return response()->json($output);
    }
}
