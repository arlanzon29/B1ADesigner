<?php

namespace App\Interfaces;

use App\Models\OCRD;
use Illuminate\Http\Request;

interface IOCRDRepository
{
    public function getByKey(string $cardCode): array;
    public function add(OCRD $elemento): array;
    public function update(OCRD $elemento): array;
    public function delete(string $cardCode): array;
    public function patch(Request $request, string $cardCode): array;
}