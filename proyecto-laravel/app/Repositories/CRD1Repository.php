<?php

namespace App\Repositories;

use App\Interfaces\ICRD1Repository;
use App\Models\CRD1;
use Illuminate\Database\Eloquent\Collection;

class CRD1Repository implements ICRD1Repository
{
    public function getByKey(string $cardCode, int $lineId): array
    {
        try {
            $elemento = CRD1::where('CardCode', $cardCode)
                ->where('LineId', $lineId)
                ->first();
            if ($elemento) {
                return [
                    'success' => true,
                    'data' => $elemento,
                    'message' => 'Dirección encontrada'
                ];
            }
            return [
                'success' => false,
                'data' => null,
                'message' => 'Dirección no encontrada'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function getAll(string $cardCode): array
    {
        try {
            $elementos = CRD1::where('CardCode', $cardCode)->get();
            return [
                'success' => true,
                'data' => $elementos,
                'message' => 'Direcciónes encontradas'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function add(CRD1 $elemento): array
    {
        try {
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Dirección guardada correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ];
        }
    }

    public function update(CRD1 $elemento): array
    {
        try {
            $existing = CRD1::where('CardCode', $elemento->CardCode)
                ->where('LineId', $elemento->LineId)
                ->first();
            if (!$existing) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Dirección no encontrada'
                ];
            }
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Dirección actualizada correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ];
        }
    }

    public function delete(string $cardCode, int $lineId): array
    {
        try {
            $elemento = CRD1::where('CardCode', $cardCode)
                ->where('LineId', $lineId)
                ->first();
            if (!$elemento) {
                return [
                    'success' => false,
                    'data' => false,
                    'message' => 'Dirección no encontrada'
                ];
            }
            $elemento->delete();
            return [
                'success' => true,
                'data' => true,
                'message' => 'Dirección eliminada correctamente'
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