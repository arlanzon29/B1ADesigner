<?php

namespace App\InterfacesService;

use App\ModelsService\OigeServiceRequest;
use App\Models\OIGE;

interface IOigeService
{
    public function crear(OigeServiceRequest $request): array;
}