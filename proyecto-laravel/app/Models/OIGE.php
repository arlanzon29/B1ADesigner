<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OIGE extends Model
{
    protected $table = 'oige';
    protected $primaryKey = 'Code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Code',
        'DocDate',
    ];
}