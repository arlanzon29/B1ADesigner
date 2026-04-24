<?php

namespace App\Interfaces;

use App\ModelsForms\Frm020Unbound;

interface IFrm020ConsultaClientesRepository
{
    public function crearFiltro(array $datos): Frm020Unbound;
    public function consultarClientes(Frm020Unbound $filtro): array;
}