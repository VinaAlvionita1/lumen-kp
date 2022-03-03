<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    public $timestamps = false;
    protected $table = 'dokumen';
    protected $primaryKey = 'id_berkas';
    protected $fillable = ['id_milestone', 'nama_berkas', 'file', 'link', 'keterangan', 'tgl_upload'];
}
