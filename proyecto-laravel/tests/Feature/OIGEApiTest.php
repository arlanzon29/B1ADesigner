<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OIGE;

class OIGEApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_oige_by_key()
    {
        OIGE::create([
            'Code' => 'TEST001',
            'DocDate' => '2026-04-25'
        ]);

        $response = $this->getJson('/api/oige/TEST001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Code' => 'TEST001'
                ]
            ]);
    }

    public function test_can_create_oige()
    {
        $data = [
            'Code' => 'TEST002',
            'DocDate' => '2026-04-25'
        ];

        $response = $this->postJson('/api/oige', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oige', ['Code' => 'TEST002']);
    }

    public function test_can_update_oige()
    {
        OIGE::create([
            'Code' => 'TEST003',
            'DocDate' => '2026-04-25'
        ]);

        $data = [
            'Code' => 'TEST003',
            'DocDate' => '2026-04-26'
        ];

        $response = $this->putJson('/api/oige/TEST003', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oige', [
            'Code' => 'TEST003',
            'DocDate' => '2026-04-26'
        ]);
    }

    public function test_can_delete_oige()
    {
        OIGE::create([
            'Code' => 'TEST004',
            'DocDate' => '2026-04-25'
        ]);

        $response = $this->deleteJson('/api/oige/TEST004');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('oige', ['Code' => 'TEST004']);
    }

    public function test_returns_404_when_oige_not_found()
    {
        $response = $this->getJson('/api/oige/NONEXISTENT');

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'No encontrado'
            ]);
    }
}