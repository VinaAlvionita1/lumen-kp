<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    public $timestamps = false;
    protected $table = 'berkas';
    protected $primaryKey = 'id_berkas';
    protected $fillable = ['id_milestone', 'nama_berkas', 'file', 'keterangan', 'tgl_upload'];
}
