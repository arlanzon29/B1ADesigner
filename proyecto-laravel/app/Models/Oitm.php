<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OITM extends Model
{
    protected $table = 'oitm';
    protected $primaryKey = 'ItemCode';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ItemCode',
        'ItemName',
        'OnHand',
    ];

    protected $casts = [
        'OnHand' => 'decimal:2',
    ];
}