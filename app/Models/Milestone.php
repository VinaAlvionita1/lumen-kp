<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    public $timestamps = false;
    protected $table = 'milestone';
    protected $primaryKey = 'id_milestone';
    protected $fillable = ['nama_milestone', 'id_proyek'];
}
