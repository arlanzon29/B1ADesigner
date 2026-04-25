<?php

namespace App\Http\Controllers;

use App\Interfaces\IOITTRepository;
use Illuminate\Http\Request;

class OITTController extends Controller
{
    private $repository;

    public function __construct(IOITTRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getByKey(string $code)
    {
        return $this->repository->getByKey($code);
    }

    public function add(Request $request)
    {
        $elemento = new \App\Models\OITT();
        $elemento->Code = $request->input('Code');
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->ItemName = $request->input('ItemName');
        $elemento->Quantity = $request->input('Quantity', 1);
        return $this->repository->add($elemento);
    }

    public function update(Request $request)
    {
        $elemento = new \App\Models\OITT();
        $elemento->Code = $request->input('Code');
        $elemento->ItemCode = $request->input('ItemCode');
        $elemento->ItemName = $request->input('ItemName');
        $elemento->Quantity = $request->input('Quantity', 1);
        return $this->repository->update($elemento);
    }

    public function delete(string $code)
    {
        return $this->repository->delete($code);
    }

    public function getByItemCode(Request $request)
    {
        $itemCode = $request->query('itemCode') ?: null;
        return $this->repository->getByItemCode($itemCode);
    }
}