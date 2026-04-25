<?php

namespace App\Interfaces;

use App\Models\OSHP;

interface IOSHPRepository
{
    /**
     * Obtiene una clase de expedición por su clave primaria.
     *
     * @param string $code
     * @return array
     */
    public function getByKey(string $code): array;

    /**
     * Añade una nueva clase de expedición.
     *
     * @param OSHP $elemento
     * @return array
     */
    public function add(OSHP $elemento): array;

    /**
     * Actualiza una clase de expedición existente.
     *
     * @param OSHP $elemento
     * @return array
     */
    public function update(OSHP $elemento): array;

    /**
     * Elimina una clase de expedición por su clave.
     *
     * @param string $code
     * @return array
     */
    public function delete(string $code): array;
}