<?php

namespace App\Interfaces;

use App\Models\IGE1;

interface IIGE1Repository
{
    public function getByKey(string $code, int $lineId): array;
    public function getByCode(string $code): array;
    public function add(IGE1 $elemento): array;
    public function update(IGE1 $elemento): array;
    public function delete(string $code, int $lineId): array;
}