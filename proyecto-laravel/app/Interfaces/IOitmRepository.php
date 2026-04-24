<?php

namespace App\Interfaces;

use App\Models\Oitm;
use Illuminate\Http\Request;

interface IOitmRepository
{
    /**
     * Obtiene un artículo por su clave primaria.
     *
     * @param string $itemCode
     * @return array
     */
    public function getByKey(string $itemCode): array;

    /**
     * Añade un nuevo artículo.
     *
     * @param Oitm $elemento
     * @return array
     */
    public function add(Oitm $elemento): array;

    /**
     * Actualiza un artículo existente.
     *
     * @param Oitm $elemento
     * @return array
     */
    public function update(Oitm $elemento): array;

    /**
     * Elimina un artículo por su clave.
     *
     * @param string $itemCode
     * @return array
     */
    public function delete(string $itemCode): array;

    /**
     * Actualiza parcialmente un artículo (ItemName y/o OnHand).
     *
     * @param Request $request
     * @param string $itemCode
     * @return array
     */
    public function patch(Request $request, string $itemCode): array;

    /**
     * Consulta artículos por filtro.
     *
     * @param string|null $itemCode
     * @return array
     */
    public function search(?string $itemCode = null): array;
}