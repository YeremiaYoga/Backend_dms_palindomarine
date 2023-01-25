<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projek extends Model
{
    use HasFactory;

    protected $fillable = [
        'projek_id','nama_projek', 'projek_tipe', 'hull_number', 'client'
    ];
}
