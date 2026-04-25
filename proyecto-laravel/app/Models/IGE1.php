<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IGE1 extends Model
{
    protected $table = 'ige1';
    protected $primaryKey = ['Code', 'LineId'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Code',
        'LineId',
        'ItemCode',
        'Dscripcion',
        'Quantity',
        'WhsCode',
    ];

    protected $casts = [
        'LineId' => 'integer',
        'Quantity' => 'decimal:2',
    ];

    public function oige()
    {
        return $this->belongsTo(OIGE::class, 'Code', 'Code');
    }

    public function item()
    {
        return $this->belongsTo(OITM::class, 'ItemCode', 'ItemCode');
    }

    public function warehouse()
    {
        return $this->belongsTo(OWHS::class, 'WhsCode', 'WhsCode');
    }
}