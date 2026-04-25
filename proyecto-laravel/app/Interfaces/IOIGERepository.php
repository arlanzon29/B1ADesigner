<?php

namespace App\Interfaces;

use App\Models\OIGE;

interface IOIGERepository
{
    public function getByKey(string $code): array;
    public function add(OIGE $elemento): array;
    public function update(OIGE $elemento): array;
    public function delete(string $code): array;
}