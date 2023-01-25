<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploader extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_projeks', 'judul', 'drawing_number','status', 'rev','id_drafter', 'id_checker'
    ];
}
