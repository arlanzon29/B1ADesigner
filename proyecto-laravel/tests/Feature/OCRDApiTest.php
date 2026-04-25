<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OCRD;

class OCRDApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_ocrd_by_key()
    {
        OCRD::create([
            'CardCode' => 'C001',
            'CardName' => 'Cliente prueba',
            'Balance' => 100
        ]);

        $response = $this->getJson('/api/ocrd/C001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'CardCode' => 'C001'
                ]
            ]);
    }

    public function test_can_create_ocrd()
    {
        $data = [
            'CardCode' => 'C002',
            'CardName' => 'Cliente nuevo',
            'Balance' => 0
        ];

        $response = $this->postJson('/api/ocrd', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('ocrd', ['CardCode' => 'C002']);
    }

    public function test_can_update_ocrd()
    {
        OCRD::create([
            'CardCode' => 'C003',
            'CardName' => 'Cliente original',
            'Balance' => 50
        ]);

        $data = [
            'CardCode' => 'C003',
            'CardName' => 'Cliente actualizado',
            'Balance' => 200
        ];

        $response = $this->putJson('/api/ocrd/C003', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('ocrd', [
            'CardCode' => 'C003',
            'CardName' => 'Cliente actualizado'
        ]);
    }

    public function test_can_delete_ocrd()
    {
        OCRD::create([
            'CardCode' => 'C004',
            'CardName' => 'Cliente a eliminar',
            'Balance' => 0
        ]);

        $response = $this->deleteJson('/api/ocrd/C004');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('ocrd', ['CardCode' => 'C004']);
    }
}