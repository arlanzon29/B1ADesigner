<?php

namespace App\ModelsForms;

class Frm030Unbound
{
    public string $CardCode;
    public string $CardName;
    public string $CardType;

    public function __construct(
        string $CardCode = '',
        string $CardName = '',
        string $CardType = ''
    ) {
        $this->CardCode = $CardCode;
        $this->CardName = $CardName;
        $this->CardType = $CardType;
    }
}