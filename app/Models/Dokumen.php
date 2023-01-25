<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_uploaders',
        'id_revisis',
        'id_users',
        'dokumen',
        'status_dokumen',
        'url_dokumen'
    ];

    public $table = 'dokuments';
}
