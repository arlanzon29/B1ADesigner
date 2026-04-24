<?php

namespace App\Http\Controllers;

use App\InterfacesForm\IFrm010ConsultaArticulosRepository;
use Illuminate\Http\Request;

class Frm010ConsultaArticulosController extends Controller
{
    protected $repository;

    public function __construct(IFrm010ConsultaArticulosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function consultar(Request $request)
    {
        $filtro = $this->repository->crearFiltro($request->all());
        return $this->repository->consultarArticulos($filtro);
    }
}