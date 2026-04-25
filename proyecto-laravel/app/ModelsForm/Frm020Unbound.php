<?php

namespace App\ModelsForm;

class Frm020Unbound
{
    public ?string $CardCode = null;

    public function __construct(?string $CardCode = null)
    {
        $this->CardCode = $CardCode;
    }
}