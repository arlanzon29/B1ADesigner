<?php

namespace App\Repositories;

use App\InterfacesForm\IFrm010ConsultaArticulosRepository;
use App\ModelsForms\Frm010Unbound;
use App\ModelsForms\Frm010DbgArticulos;
use Illuminate\Support\Facades\DB;

class Frm010ConsultaArticulosRepository implements IFrm010ConsultaArticulosRepository
{
    public function crearFiltro(array $datos): Frm010Unbound
    {
        return new Frm010Unbound($datos['ItemCode'] ?? null);
    }

    public function consultarArticulos(Frm010Unbound $filtro): array
    {
        try {
            $resultados = DB::table('oitm')
                ->select('ItemCode', 'ItemName', 'OnHand')
                ->where('ItemCode', 'like', $filtro->ItemCode . '%')
                ->get()
                ->map(function($item) {
                    return new Frm010DbgArticulos(
                        $item->ItemCode,
                        $item->ItemName,
                        (float) $item->OnHand
                    );
                });

            return [
                'success' => true,
                'data' => $resultados,
                'message' => 'Consulta realizada'
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