<?php

namespace App\ModelsService;

class OigeServiceLinea
{
    public string $ItemCode;
    public string $Dscripcion;
    public float $Quantity;
    public string $WhsCode;

    public function __construct(
        string $ItemCode,
        string $Dscripcion,
        float $Quantity,
        string $WhsCode
    ) {
        $this->ItemCode = $ItemCode;
        $this->Dscripcion = $Dscripcion;
        $this->Quantity = $Quantity;
        $this->WhsCode = $WhsCode;
    }
}