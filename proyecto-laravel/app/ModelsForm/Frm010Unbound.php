<?php

namespace App\ModelsForm;

class Frm010Unbound
{
    public ?string $ItemCode = null;

    public function __construct(?string $ItemCode = null)
    {
        $this->ItemCode = $ItemCode;
    }
}