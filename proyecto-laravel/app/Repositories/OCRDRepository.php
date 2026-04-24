<?php

namespace App\Repositories;

use App\Interfaces\IOCRDRepository;
use App\Models\OCRD;
use Illuminate\Http\Request;

class OCRDRepository implements IOCRDRepository
{
    public function getByKey(string $cardCode): array
    {
        try {
            $elemento = OCRD::find($cardCode);
            if ($elemento) {
                return ['success' => true, 'data' => $elemento, 'message' => 'Encontrado'];
            }
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function add(OCRD $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Guardado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    public function update(OCRD $elemento): array
    {
        try {
            $existing = OCRD::find($elemento->CardCode);
            if (!$existing) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
        }
    }

    public function delete(string $cardCode): array
    {
        try {
            $elemento = OCRD::find($cardCode);
            if (!$elemento) {
                return ['success' => false, 'data' => false, 'message' => 'No encontrado'];
            }
            $elemento->delete();
            return ['success' => true, 'data' => true, 'message' => 'Eliminado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => false, 'message' => 'Error al eliminar: ' . $e->getMessage()];
        }
    }

    public function patch(Request $request, string $cardCode): array
    {
        try {
            $elemento = OCRD::find($cardCode);
            if (!$elemento) {
                return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
            }
            if ($request->has('CardName')) {
                $elemento->CardName = $request->input('CardName');
            }
            if ($request->has('CardType')) {
                $elemento->CardType = $request->input('CardType');
            }
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
        }
    }
}