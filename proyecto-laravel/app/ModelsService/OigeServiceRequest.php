<?php

namespace App\ModelsService;

class OigeServiceRequest
{
    public string $Code;
    public string $DocDate;
    public array $Lineas;

    public function __construct(
        string $Code,
        string $DocDate,
        array $Lineas = []
    ) {
        $this->Code = $Code;
        $this->DocDate = $DocDate;
        $this->Lineas = $Lineas;
    }
}