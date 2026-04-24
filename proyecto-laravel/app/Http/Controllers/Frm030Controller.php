<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Frm030Controller extends Controller
{
    public function getByKey(Request $request)
    {
        $cardCode = $request->query('cardCode');
        
        $repository = app(\App\Interfaces\IFrm030Repository::class);
        return $repository->getByKey($cardCode);
    }
}