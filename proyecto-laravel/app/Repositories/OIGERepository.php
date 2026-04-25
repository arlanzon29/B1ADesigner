<?php

namespace App\Repositories;

use App\Interfaces\IOIGERepository;
use App\Models\OIGE;

class OIGERepository implements IOIGERepository
{
    public function getByKey(string $code): array
    {
        $elemento = OIGE::find($code);
        if (!$elemento) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => $elemento, 'message' => 'OK'];
    }

    public function add(OIGE $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Guardado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    public function update(OIGE $elemento): array
    {
        try {
            $existente = OIGE::find($elemento->Code);
            if (!$existente) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            $existente->DocDate = $elemento->DocDate;
            $existente->save();
            return ['success' => true, 'data' => $existente, 'message' => 'Actualizado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
        }
    }

    public function delete(string $code): array
    {
        try {
            $elemento = OIGE::find($code);
            if (!$elemento) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            $elemento->delete();
            return ['success' => true, 'data' => null, 'message' => 'Eliminado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }
}