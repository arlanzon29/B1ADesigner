<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OITT extends Model
{
    protected $table = 'oitt';
    protected $primaryKey = 'Code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Code',
        'ItemCode',
        'ItemName',
        'Quantity',
    ];

    protected $casts = [
        'Quantity' => 'decimal:2',
    ];
}