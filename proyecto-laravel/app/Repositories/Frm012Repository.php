<?php

namespace App\Repositories;

use App\Interfaces\IFrm012Repository;
use App\Models\Oitm;

class Frm012Repository implements IFrm012Repository
{
    /**
     * Obtiene los datos de un artículo.
     *
     * @param string $itemCode
     * @return array
     */
    public function getByKey(string $itemCode): array
    {
        try {
            $elemento = Oitm::find($itemCode);
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
}