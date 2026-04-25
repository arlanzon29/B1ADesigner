<?php

namespace App\Repositories;

use App\Interfaces\IOITTRepository;
use App\Models\OITT;
use Illuminate\Support\Facades\DB;

class OITTRepository implements IOITTRepository
{
    public function getByKey(string $code): array
    {
        $elemento = OITT::find($code);
        if (!$elemento) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => $elemento, 'message' => 'OK'];
    }

    public function add(OITT $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Guardado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    public function update(OITT $elemento): array
    {
        try {
            $existente = OITT::find($elemento->Code);
            if (!$existente) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            $existente->ItemCode = $elemento->ItemCode;
            $existente->ItemName = $elemento->ItemName;
            $existente->Quantity = $elemento->Quantity;
            $existente->save();
            return ['success' => true, 'data' => $existente, 'message' => 'Actualizado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
        }
    }

    public function delete(string $code): array
    {
        try {
            $elemento = OITT::find($code);
            if (!$elemento) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            $elemento->delete();
            return ['success' => true, 'data' => null, 'message' => 'Eliminado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }

    public function getByItemCode(?string $itemCode): array
    {
        if (!$itemCode) {
            $lista = OITT::all();
        } else {
            $lista = OITT::where('ItemCode', $itemCode)->get();
        }
        return ['success' => true, 'data' => $lista, 'message' => 'OK'];
    }
}