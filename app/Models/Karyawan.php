<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    public $timestamps = false;
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = ['id_jabatan', 'nama_karyawan', 'email', 'telp'];
}
