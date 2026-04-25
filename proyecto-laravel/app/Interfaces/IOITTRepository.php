<?php

namespace App\Interfaces;

use App\Models\OITT;

interface IOITTRepository
{
    public function getByKey(string $code): array;
    public function add(OITT $elemento): array;
    public function update(OITT $elemento): array;
    public function delete(string $code): array;
    public function getByItemCode(?string $itemCode): array;
}