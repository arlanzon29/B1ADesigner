<?php

namespace App\Http\Controllers;

use App\InterfacesForm\IFrm020ConsultaClientesRepository;
use Illuminate\Http\Request;

class Frm020ConsultaClientesController extends Controller
{
    protected $repository;

    public function __construct(IFrm020ConsultaClientesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function consultar(Request $request)
    {
        $filtro = $this->repository->crearFiltro($request->all());
        return $this->repository->consultarClientes($filtro);
    }
}