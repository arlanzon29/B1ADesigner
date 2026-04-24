<?php

namespace App\Interfaces;

use App\Models\OITW;

interface IOITWRepository
{
    /**
     * Obtiene un registro de stock por su clave primaria.
     *
     * @param string $itemCode
     * @param string $whsCode
     * @return array
     */
    public function getByKey(string $itemCode, string $whsCode): array;

    /**
     * Obtiene todos los stocks de un artículo.
     *
     * @param string $itemCode
     * @return array
     */
    public function getAll(string $itemCode): array;

    /**
     * Añade un nuevo registro de stock.
     *
     * @param OITW $elemento
     * @return array
     */
    public function add(OITW $elemento): array;

    /**
     * Actualiza un registro de stock existente.
     *
     * @param OITW $elemento
     * @return array
     */
    public function update(OITW $elemento): array;

    /**
     * Elimina un registro de stock por su clave.
     *
     * @param string $itemCode
     * @param string $whsCode
     * @return array
     */
    public function delete(string $itemCode, string $whsCode): array;
}