<?php

namespace App\Services;

use App\InterfacesService\IOigeService;
use App\ModelsService\OigeServiceRequest;
use App\Models\OIGE;
use App\Models\IGE1;
use App\Models\OITM;
use App\Models\OITW;
use Illuminate\Support\Facades\DB;

class OigeService implements IOigeService
{
    public function crear(OigeServiceRequest $request): array
    {
        try {
            return DB::transaction(function () use ($request) {
                foreach ($request->Lineas as $linea) {
                    $item = OITM::find($linea->ItemCode);
                    if (!$item) {
                        return [
                            'success' => false,
                            'data' => null,
                            'message' => 'Artículo no encontrado: ' . $linea->ItemCode
                        ];
                    }
                }

                foreach ($request->Lineas as $linea) {
                    $whs = \App\Models\OWHS::find($linea->WhsCode);
                    if (!$whs) {
                        return [
                            'success' => false,
                            'data' => null,
                            'message' => 'Almacén no encontrado: ' . $linea->WhsCode
                        ];
                    }
                }

                $cabecera = new OIGE();
                $cabecera->Code = $request->Code;
                $cabecera->DocDate = $request->DocDate;
                $cabecera->save();

                $lineId = 1;
                foreach ($request->Lineas as $linea) {
                    $lineaIGE1 = new IGE1();
                    $lineaIGE1->Code = $request->Code;
                    $lineaIGE1->LineId = $lineId;
                    $lineaIGE1->ItemCode = $linea->ItemCode;
                    $lineaIGE1->Dscripcion = $linea->Dscripcion;
                    $lineaIGE1->Quantity = $linea->Quantity;
                    $lineaIGE1->WhsCode = $linea->WhsCode;
                    $lineaIGE1->save();

                    OITM::where('ItemCode', $linea->ItemCode)
                        ->increment('OnHand', $linea->Quantity);

                    $stockAlmacen = OITW::where('ItemCode', $linea->ItemCode)
                        ->where('WhsCode', $linea->WhsCode)
                        ->first();

                    if ($stockAlmacen) {
                        OITW::where('ItemCode', $linea->ItemCode)
                            ->where('WhsCode', $linea->WhsCode)
                            ->increment('OnHand', $linea->Quantity);
                    } else {
                        $nuevoStock = new OITW();
                        $nuevoStock->ItemCode = $linea->ItemCode;
                        $nuevoStock->WhsCode = $linea->WhsCode;
                        $nuevoStock->OnHand = $linea->Quantity;
                        $nuevoStock->save();
                    }

                    $lineId++;
                }

                return [
                    'success' => true,
                    'data' => $cabecera,
                    'message' => 'Transacción de entrada creada correctamente'
                ];
            });
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al crear la transacción: ' . $e->getMessage()
            ];
        }
    }
}