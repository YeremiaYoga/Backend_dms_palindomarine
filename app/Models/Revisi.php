<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Revisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_users',
        'id_uploaders',
        'nama_revisi',
        'tipe_revisi',
        'status_revisi',
        'tanggal',
    ];

    public $table = 'revisis';

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('d-m-Y');
        }
    }


}
