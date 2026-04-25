<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ITT1 extends Model
{
    protected $table = 'itt1';
    protected $primaryKey = ['Code', 'LineId'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Code',
        'LineId',
        'ItemCode',
        'ItemName',
        'Quantity',
    ];

    protected $casts = [
        'Quantity' => 'decimal:2',
        'LineId' => 'integer',
    ];
}