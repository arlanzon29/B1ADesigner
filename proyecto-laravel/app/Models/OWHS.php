<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OWHS extends Model
{
    protected $table = 'owhs';
    protected $primaryKey = 'WhsCode';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'WhsCode',
        'WhsName',
    ];
}