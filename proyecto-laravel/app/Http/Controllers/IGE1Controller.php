<?php

namespace App\Http\Controllers;

use App\Interfaces\IIGE1Repository;
use Illuminate\Http\Request;

class IGE1Controller extends Controller
{
    private $repository;

    public function __construct(IIGE1Repository $repository)
    {
        $this->repository = $repository;
    }

    public function getByKey(string $code, int $lineId)
    {
        return $this->repository->getByKey($code, $lineId);
    }

    public function getByCode(Request $request)
    {
        $code = $request->query('Code');
        return $this->repository->getByCode($code);
    }

    public function add(Request $request)
    {
        $elemento = new \App\Models\IGE1();
        $elemento->Code = $request->input('Code');
        $elemento->LineId = (int) $request->input('LineId');
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->Dscripcion = $request->input('Dscripcion');
        $elemento->Quantity = (float) $request->input('Quantity');
        $elemento->WhsCode = $request->input('WhsCode');
        return $this->repository->add($elemento);
    }

    public function update(Request $request)
    {
        $elemento = new \App\Models\IGE1();
        $elemento->Code = $request->input('Code');
        $elemento->LineId = (int) $request->input('LineId');
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->Dscripcion = $request->input('Dscripcion');
        $elemento->Quantity = (float) $request->input('Quantity');
        $elemento->WhsCode = $request->input('WhsCode');
        return $this->repository->update($elemento);
    }

    public function delete(string $code, int $lineId)
    {
        return $this->repository->delete($code, $lineId);
    }
}