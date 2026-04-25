<?php

namespace App\Interfaces;

use App\ModelsForm\Frm010Unbound;

interface IFrm010ConsultaArticulosRepository
{
    public function crearFiltro(array $datos): Frm010Unbound;
    public function consultarArticulos(Frm010Unbound $filtro): array;
}