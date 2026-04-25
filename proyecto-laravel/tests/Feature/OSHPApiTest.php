<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OSHP;

class OSHPApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_oshp_by_key()
    {
        OSHP::create([
            'Code' => 'EXP001',
            'Name' => 'Expedición rápida'
        ]);

        $response = $this->getJson('/api/oshp/EXP001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Code' => 'EXP001'
                ]
            ]);
    }

    public function test_can_create_oshp()
    {
        $data = [
            'Code' => 'EXP002',
            'Name' => 'Expedición estándar'
        ];

        $response = $this->postJson('/api/oshp', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oshp', ['Code' => 'EXP002']);
    }

    public function test_can_update_oshp()
    {
        OSHP::create([
            'Code' => 'EXP003',
            'Name' => 'Expedición original'
        ]);

        $data = [
            'Code' => 'EXP003',
            'Name' => 'Expedición actualizada'
        ];

        $response = $this->putJson('/api/oshp/EXP003', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oshp', [
            'Code' => 'EXP003',
            'Name' => 'Expedición actualizada'
        ]);
    }

    public function test_can_delete_oshp()
    {
        OSHP::create([
            'Code' => 'EXP004',
            'Name' => 'Expedición a eliminar'
        ]);

        $response = $this->deleteJson('/api/oshp/EXP004');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('oshp', ['Code' => 'EXP004']);
    }

    public function test_returns_404_when_oshp_not_found()
    {
        $response = $this->getJson('/api/oshp/NONEXISTENT');

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'Clase de expedición no encontrada'
            ]);
    }
}