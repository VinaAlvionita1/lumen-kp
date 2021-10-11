<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    public $timestamps = false;
    protected $table = 'proyek';
    protected $primaryKey = 'id_proyek';
    protected $fillable = ['nomor_proyek', 'nama_proyek', 'lokasi', 'dinas', 'thn_anggaran', 'harga', 'tgl_mulai_proyek', 'tgl_selesai_proyek'];
}
