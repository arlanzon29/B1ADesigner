<?php

namespace App\Http\Controllers;

use App\Interfaces\IOIGERepository;
use Illuminate\Http\Request;

class OIGEController extends Controller
{
    private $repository;

    public function __construct(IOIGERepository $repository)
    {
        $this->repository = $repository;
    }

    public function getByKey(string $code)
    {
        return $this->repository->getByKey($code);
    }

    public function add(Request $request)
    {
        $elemento = new \App\Models\OIGE();
        $elemento->Code = $request->input('Code');
        $elemento->DocDate = $request->input('DocDate');
        return $this->repository->add($elemento);
    }

    public function update(Request $request)
    {
        $elemento = new \App\Models\OIGE();
        $elemento->Code = $request->input('Code');
        $elemento->DocDate = $request->input('DocDate');
        return $this->repository->update($elemento);
    }

    public function delete(string $code)
    {
        return $this->repository->delete($code);
    }
}