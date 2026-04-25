<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OSHP extends Model
{
    protected $table = 'oshp';
    protected $primaryKey = 'Code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Code',
        'Name',
    ];
}