<?php

namespace App\Repositories;

use App\Interfaces\IFrm012Repository;
use App\Models\OITM;
use App\ModelsForms\Frm012Unbound;

class Frm012Repository implements IFrm012Repository
{
    public function getByKey(string $itemCode): array
    {
        try {
            $elemento = OITM::find($itemCode);
            if ($elemento) {
                $modelo = new Frm012Unbound(
                    $elemento->ItemCode,
                    $elemento->ItemName,
                    (float) $elemento->OnHand
                );
                return [
                    'success' => true,
                    'data' => $modelo,
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