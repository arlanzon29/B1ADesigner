<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CRD1 extends Model
{
    protected $table = 'crd1';
    public $timestamps = false;

    protected $primaryKey = ['CardCode', 'LineId'];
    public $incrementing = false;

    protected $fillable = [
        'CardCode',
        'LineId',
        'Address',
    ];
}