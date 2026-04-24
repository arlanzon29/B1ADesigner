<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OITW extends Model
{
    protected $table = 'oitw';
    public $timestamps = false;

    protected $primaryKey = ['ItemCode', 'WhsCode'];
    public $incrementing = false;

    protected $fillable = [
        'ItemCode',
        'WhsCode',
        'OnHand',
    ];

    protected $casts = [
        'OnHand' => 'double',
    ];
}