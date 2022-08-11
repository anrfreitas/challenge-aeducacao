<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Hey, I decided to not use softDelete, trying to gain some time here :)
     */
    protected $fillable = [
        'name',
        'cpf',
    ];

    protected $dates = ['created_at', 'updated_at'];
    protected $table = 'students';
    public $timestamps = true;
}
