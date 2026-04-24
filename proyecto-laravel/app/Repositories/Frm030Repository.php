<?php

namespace App\Repositories;

use App\Interfaces\IFrm030Repository;
use App\Models\Ocrd;

class Frm030Repository implements IFrm030Repository
{
    /**
     * Obtiene los datos de un cliente.
     *
     * @param string $cardCode
     * @return array
     */
    public function getByKey(string $cardCode): array
    {
        try {
            $elemento = Ocrd::find($cardCode);
            if ($elemento) {
                return [
                    'success' => true,
                    'data' => $elemento,
                    'message' => 'Cliente encontrado'
                ];
            }
            return [
                'success' => false,
                'data' => null,
                'message' => 'Cliente no encontrado'
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