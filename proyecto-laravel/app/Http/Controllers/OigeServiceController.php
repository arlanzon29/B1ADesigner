<?php

namespace App\Http\Controllers;

use App\InterfacesService\IOigeService;
use App\ModelsService\OigeServiceRequest;
use Illuminate\Http\Request;

class OigeController extends Controller
{
    private $service;

    public function __construct(IOigeService $service)
    {
        $this->service = $service;
    }

    public function crear(Request $request)
    {
        $lineas = [];
        foreach ($request->input('Lineas', []) as $linea) {
            $lineas[] = new \App\ModelsService\OigeServiceLinea(
                $linea['ItemCode'],
                $linea['Dscripcion'],
                (float) $linea['Quantity'],
                $linea['WhsCode']
            );
        }

        $requestModel = new OigeServiceRequest(
            $request->input('Code'),
            $request->input('DocDate'),
            $lineas
        );

        return $this->service->crear($requestModel);
    }
}