<?php

namespace App\Repositories;

use App\Interfaces\IIGE1Repository;
use App\Models\IGE1;
use Illuminate\Support\Facades\DB;

class IGE1Repository implements IIGE1Repository
{
    public function getByKey(string $code, int $lineId): array
    {
        $elemento = IGE1::where('Code', $code)->where('LineId', $lineId)->first();
        if (!$elemento) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => $elemento, 'message' => 'OK'];
    }

    public function getByCode(string $code): array
    {
        $elementos = IGE1::where('Code', $code)->orderBy('LineId')->get();
        return ['success' => true, 'data' => $elementos, 'message' => 'OK'];
    }

    public function add(IGE1 $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Guardado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    public function update(IGE1 $elemento): array
    {
        try {
            $actualizado = IGE1::where('Code', $elemento->Code)
                ->where('LineId', $elemento->LineId)
                ->update([
                    'ItemCode' => $elemento->ItemCode,
                    'Dscripcion' => $elemento->Dscripcion,
                    'Quantity' => $elemento->Quantity,
                    'WhsCode' => $elemento->WhsCode
                ]);
            if ($actualizado === 0) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
        }
    }

    public function delete(string $code, int $lineId): array
    {
        try {
            $eliminado = IGE1::where('Code', $code)->where('LineId', $lineId)->delete();
            if ($eliminado === 0) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            return ['success' => true, 'data' => null, 'message' => 'Eliminado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }
}