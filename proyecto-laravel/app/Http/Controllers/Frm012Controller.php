<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Frm012Controller extends Controller
{
    public function getByKey(Request $request)
    {
        $itemCode = $request->query('itemCode');
        
        $repository = app(\App\Interfaces\IFrm012Repository::class);
        return $repository->getByKey($itemCode);
    }
}