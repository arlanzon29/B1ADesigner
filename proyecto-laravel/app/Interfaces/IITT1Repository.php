<?php

namespace App\Interfaces;

use App\Models\ITT1;

interface IITT1Repository
{
    public function getByKey(string $code, int $lineId): array;
    public function add(ITT1 $elemento): array;
    public function update(ITT1 $elemento): array;
    public function delete(string $code, int $lineId): array;
    public function getByCode(string $code): array;
}