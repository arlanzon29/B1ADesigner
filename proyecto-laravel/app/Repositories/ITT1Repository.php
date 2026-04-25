<?php

namespace App\Repositories;

use App\Interfaces\IITT1Repository;
use App\Models\ITT1;
use Illuminate\Support\Facades\DB;

class ITT1Repository implements IITT1Repository
{
    public function getByKey(string $code, int $lineId): array
    {
        $elemento = ITT1::where('Code', $code)->where('LineId', $lineId)->first();
        if (!$elemento) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => $elemento, 'message' => 'OK'];
    }

    public function add(ITT1 $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Guardado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    public function update(ITT1 $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
        }
    }

    public function delete(string $code, int $lineId): array
    {
        try {
            $elemento = ITT1::where('Code', $code)->where('LineId', $lineId)->first();
            if (!$elemento) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            $elemento->delete();
            return ['success' => true, 'data' => null, 'message' => 'Eliminado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }

    public function getByCode(string $code): array
    {
        $lista = ITT1::where('Code', $code)->orderBy('LineId')->get();
        return ['success' => true, 'data' => $lista, 'message' => 'OK'];
    }
}