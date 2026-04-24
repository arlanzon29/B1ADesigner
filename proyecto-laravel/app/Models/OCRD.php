<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OCRD extends Model
{
    protected $table = 'ocrd';
    protected $primaryKey = 'CardCode';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'CardCode',
        'CardName',
        'CardType',
    ];
}