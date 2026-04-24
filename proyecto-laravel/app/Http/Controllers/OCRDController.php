<?php

namespace App\Http\Controllers;

use App\Interfaces\IOCRDRepository;
use App\Models\OCRD;
use Illuminate\Http\Request;

class OCRDController extends Controller
{
    protected $repository;

    public function __construct(IOCRDRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getByKey(string $cardCode)
    {
        return $this->repository->getByKey($cardCode);
    }

    public function add(Request $request)
    {
        $elemento = new OCRD();
        $elemento->CardCode = $request->input('CardCode');
        $elemento->CardName = $request->input('CardName');
        $elemento->CardType = $request->input('CardType');

        return $this->repository->add($elemento);
    }

    public function update(Request $request, string $cardCode)
    {
        $elemento = OCRD::find($cardCode);
        if (!$elemento) {
            $elemento = new OCRD();
            $elemento->CardCode = $cardCode;
        }
        $elemento->CardName = $request->input('CardName');
        $elemento->CardType = $request->input('CardType');

        return $this->repository->update($elemento);
    }

    public function delete(string $cardCode)
    {
        return $this->repository->delete($cardCode);
    }

    public function patch(Request $request, string $cardCode)
    {
        return $this->repository->patch($request, $cardCode);
    }
}