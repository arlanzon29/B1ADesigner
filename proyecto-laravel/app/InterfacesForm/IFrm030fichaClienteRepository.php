<?php

namespace App\Interfaces;

interface IFrm030fichaClienteRepository
{
    /**
     * Obtiene los datos de un cliente.
     *
     * @param string $cardCode
     * @return array
     */
    public function getByKey(string $cardCode): array;
}