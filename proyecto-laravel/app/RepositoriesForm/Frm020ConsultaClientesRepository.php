<?php

namespace App\Repositories;

use App\InterfacesForm\IFrm020ConsultaClientesRepository;
use App\ModelsForm\Frm020Unbound;
use App\ModelsForm\Frm020DbgClientes;
use Illuminate\Support\Facades\DB;

class Frm020ConsultaClientesRepository implements IFrm020ConsultaClientesRepository
{
    public function crearFiltro(array $datos): Frm020Unbound
    {
        return new Frm020Unbound($datos['CardCode'] ?? null);
    }

    public function consultarClientes(Frm020Unbound $filtro): array
    {
        try {
            $resultados = DB::table('ocrd')
                ->select('CardCode', 'CardName', 'CardType')
                ->where('CardCode', 'like', $filtro->CardCode . '%')
                ->get()
                ->map(function($item) {
                    return new Frm020DbgClientes(
                        $item->CardCode,
                        $item->CardName,
                        $item->CardType
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