<?php

namespace App\Interfaces;

use App\ModelsForms\Frm010Unbound;

interface IFrm010ConsultaArticulosRepository
{
    public function crearFiltro(array $datos): Frm010Unbound;
    public function consultarArticulos(Frm010Unbound $filtro): array;
}