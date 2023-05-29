<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes; //mendaftarkan fitur softdeletes
    protected $fillable =[
        'nama',
        'nis',
        'rombel',
        'rayon',
    ];

    protected $casts = [ 'deleted_at'=>'datetime'];

    //nonaktif timestamps (created_at dan updated_at) karena pada table yg dibuat tidak terdapat column tersebut
    //public $timestamps = false;
}

