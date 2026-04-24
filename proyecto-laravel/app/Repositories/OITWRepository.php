<?php

namespace App\Repositories;

use App\Interfaces\IOITWRepository;
use App\Models\OITW;

class OITWRepository implements IOITWRepository
{
    public function getByKey(string $itemCode, string $whsCode): array
    {
        try {
            $elemento = OITW::where('ItemCode', $itemCode)
                ->where('WhsCode', $whsCode)
                ->first();
            if ($elemento) {
                return [
                    'success' => true,
                    'data' => $elemento,
                    'message' => 'Stock encontrado'
                ];
            }
            return [
                'success' => false,
                'data' => null,
                'message' => 'Stock no encontrado'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function getAll(string $itemCode): array
    {
        try {
            $elementos = OITW::where('ItemCode', $itemCode)->get();
            return [
                'success' => true,
                'data' => $elementos,
                'message' => 'Stocks encontrados'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function add(OITW $elemento): array
    {
        try {
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Stock guardado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ];
        }
    }

    public function update(OITW $elemento): array
    {
        try {
            $existing = OITW::where('ItemCode', $elemento->ItemCode)
                ->where('WhsCode', $elemento->WhsCode)
                ->first();
            if (!$existing) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Stock no encontrado'
                ];
            }
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Stock actualizado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ];
        }
    }

    public function delete(string $itemCode, string $whsCode): array
    {
        try {
            $elemento = OITW::where('ItemCode', $itemCode)
                ->where('WhsCode', $whsCode)
                ->first();
            if (!$elemento) {
                return [
                    'success' => false,
                    'data' => false,
                    'message' => 'Stock no encontrado'
                ];
            }
            $elemento->delete();
            return [
                'success' => true,
                'data' => true,
                'message' => 'Stock eliminado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ];
        }
    }
}