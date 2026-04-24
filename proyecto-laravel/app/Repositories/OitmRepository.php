<?php

namespace App\Repositories;

use App\Interfaces\IOitmRepository;
use App\Models\OITM;
use Illuminate\Http\Request;

class OitmRepository implements IOitmRepository
{
    /**
     * Obtiene un artículo por su clave primaria.
     *
     * @param string $itemCode
     * @return array
     */
    public function getByKey(string $itemCode): array
    {
        try {
            $elemento = OITM::find($itemCode);
            if ($elemento) {
                return [
                    'success' => true,
                    'data' => $elemento,
                    'message' => 'Artículo encontrado'
                ];
            }
            return [
                'success' => false,
                'data' => null,
                'message' => 'Artículo no encontrado'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Añade un nuevo artículo.
     *
     * @param Oitm $elemento
     * @return array
     */
    public function add(Oitm $elemento): array
    {
        try {
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Artículo guardado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Actualiza un artículo existente.
     *
     * @param Oitm $elemento
     * @return array
     */
    public function update(Oitm $elemento): array
    {
        try {
            $existing = OITM::find($elemento->ItemCode);
            if (!$existing) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Artículo no encontrado'
                ];
            }
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Artículo actualizado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un artículo por su clave.
     *
     * @param string $itemCode
     * @return array
     */
    public function delete(string $itemCode): array
    {
        try {
            $elemento = OITM::find($itemCode);
            if (!$elemento) {
                return [
                    'success' => false,
                    'data' => false,
                    'message' => 'Artículo no encontrado'
                ];
            }
            $elemento->delete();
            return [
                'success' => true,
                'data' => true,
                'message' => 'Artículo eliminado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Actualiza parcialmente un artículo (ItemName y/o OnHand).
     *
     * @param Request $request
     * @param string $itemCode
     * @return array
     */
    public function patch(Request $request, string $itemCode): array
    {
        try {
            $elemento = OITM::find($itemCode);
            if (!$elemento) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Artículo no encontrado'
                ];
            }
            $itemName = $request->input('ItemName');
            $onHand = $request->input('OnHand');

            if ($itemName !== null) {
                $elemento->ItemName = $itemName;
            }
            if ($onHand !== null) {
                $elemento->OnHand = $onHand;
            }
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Artículo actualizado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ];
        }
    }

    public function search(?string $itemCode = null): array
    {
        try {
            $query = OITM::query();

            if ($itemCode) {
                $query->where('ItemCode', 'like', $itemCode . '%');
            }

            $resultados = $query->get();

            return [
                'success' => true,
                'data' => $resultados,
                'message' => 'Consulta realizada'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error en la consulta: ' . $e->getMessage()
            ];
        }
    }
}