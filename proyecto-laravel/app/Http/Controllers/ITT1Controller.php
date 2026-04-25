<?php

namespace App\Http\Controllers;

use App\Interfaces\IITT1Repository;
use Illuminate\Http\Request;

class ITT1Controller extends Controller
{
    private $repository;

    public function __construct(IITT1Repository $repository)
    {
        $this->repository = $repository;
    }

    public function getByKey(string $code, int $lineId)
    {
        return $this->repository->getByKey($code, $lineId);
    }

    public function add(Request $request)
    {
        $elemento = new \App\Models\ITT1();
        $elemento->Code = $request->input('Code');
        $elemento->LineId = $request->input('LineId');
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->ItemName = $request->input('ItemName');
        $elemento->Quantity = $request->input('Quantity', 1);
        return $this->repository->add($elemento);
    }

    public function update(Request $request)
    {
        $elemento = new \App\Models\ITT1();
        $elemento->Code = $request->input('Code');
        $elemento->LineId = $request->input('LineId');
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->ItemName = $request->input('ItemName');
        $elemento->Quantity = $request->input('Quantity', 1);
        return $this->repository->update($elemento);
    }

    public function delete(string $code, int $lineId)
    {
        return $this->repository->delete($code, $lineId);
    }

    public function getByCode(Request $request)
    {
        $code = $request->query('code');
        return $this->repository->getByCode($code);
    }
}