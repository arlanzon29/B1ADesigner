<?php

namespace App\Interfaces;

use App\Models\CRD1;

interface ICRD1Repository
{
    /**
     * Obtiene una dirección por su clave primaria.
     *
     * @param string $cardCode
     * @param int $lineId
     * @return array
     */
    public function getByKey(string $cardCode, int $lineId): array;

    /**
     * Obtiene todas las direcciones de un cliente.
     *
     * @param string $cardCode
     * @return array
     */
    public function getAll(string $cardCode): array;

    /**
     * Añade una nueva dirección.
     *
     * @param CRD1 $elemento
     * @return array
     */
    public function add(CRD1 $elemento): array;

    /**
     * Actualiza una dirección existente.
     *
     * @param CRD1 $elemento
     * @return array
     */
    public function update(CRD1 $elemento): array;

    /**
     * Elimina una dirección por su clave.
     *
     * @param string $cardCode
     * @param int $lineId
     * @return array
     */
    public function delete(string $cardCode, int $lineId): array;
}