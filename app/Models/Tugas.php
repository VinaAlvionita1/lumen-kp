<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    public $timestamps = false;
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    protected $fillable = ['id_status', 'id_kategori', 'id_karyawan', 'id_milestone', 'nama_tugas','keterangan_tugas', 'tgl_mulai_tugas', 'tgl_selesai_tugas'];

}
