<?php

namespace App\Interfaces;

interface IFrm012fichaArticuloRepository
{
    /**
     * Obtiene los datos de un artículo.
     *
     * @param string $itemCode
     * @return array
     */
    public function getByKey(string $itemCode): array;
}