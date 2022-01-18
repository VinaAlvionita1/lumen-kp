<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;
    protected $table = 'notification';
    protected $primaryKey = 'id_notification';
    protected $fillable = ['id_proyek', 'tgl_notif', 'pesan'];
}
