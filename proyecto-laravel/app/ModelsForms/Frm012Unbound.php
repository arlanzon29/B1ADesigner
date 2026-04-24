<?php

namespace App\ModelsForms;

class Frm012Unbound
{
    public string $ItemCode;
    public string $ItemName;
    public float $OnHand;

    public function __construct(
        string $ItemCode = '',
        string $ItemName = '',
        float $OnHand = 0
    ) {
        $this->ItemCode = $ItemCode;
        $this->ItemName = $ItemName;
        $this->OnHand = $OnHand;
    }
}