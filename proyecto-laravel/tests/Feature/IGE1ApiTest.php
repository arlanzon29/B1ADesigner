<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\IGE1;
use App\Models\OIGE;
use App\Models\OITM;
use App\Models\OWHS;

class IGE1ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        OITM::create([
            'ItemCode' => 'A001',
            'ItemName' => 'Articulo prueba 1'
        ]);
        OITM::create([
            'ItemCode' => 'A002',
            'ItemName' => 'Articulo prueba 2'
        ]);
        OWHS::create([
            'WhsCode' => 'WH01',
            'WhsName' => 'Almacen 1'
        ]);
        OWHS::create([
            'WhsCode' => 'WH02',
            'WhsName' => 'Almacen 2'
        ]);
        OIGE::create([
            'Code' => 'TEST001',
            'DocDate' => '2026-04-25'
        ]);
    }

    public function test_can_get_ige1_by_key()
    {
        IGE1::create([
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001',
            'Dscripcion' => 'Articulo de prueba',
            'Quantity' => 10.5,
            'WhsCode' => 'WH01'
        ]);

        $response = $this->getJson('/api/ige1/TEST001/0');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Code' => 'TEST001',
                    'LineId' => 0
                ]
            ]);
    }

    public function test_can_get_ige1_by_code()
    {
        IGE1::create([
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001',
            'Dscripcion' => 'Articulo 1',
            'Quantity' => 10.5,
            'WhsCode' => 'WH01'
        ]);

        IGE1::create([
            'Code' => 'TEST001',
            'LineId' => 1,
            'ItemCode' => 'A002',
            'Dscripcion' => 'Articulo 2',
            'Quantity' => 20.0,
            'WhsCode' => 'WH02'
        ]);

        $response = $this->getJson('/api/ige1?Code=TEST001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonCount(2, 'data');
    }

    public function test_can_create_ige1()
    {
        $data = [
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001',
            'Dscripcion' => 'Articulo de prueba',
            'Quantity' => 10.5,
            'WhsCode' => 'WH01'
        ];

        $response = $this->postJson('/api/ige1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('ige1', [
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001'
        ]);
    }

    public function test_can_update_ige1()
    {
        IGE1::create([
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001',
            'Dscripcion' => 'Articulo original',
            'Quantity' => 10.5,
            'WhsCode' => 'WH01'
        ]);

        $data = [
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001',
            'Dscripcion' => 'Articulo actualizado',
            'Quantity' => 15.0,
            'WhsCode' => 'WH01'
        ];

        $response = $this->putJson('/api/ige1/TEST001/0', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('ige1', [
            'Code' => 'TEST001',
            'LineId' => 0,
            'Dscripcion' => 'Articulo actualizado',
            'Quantity' => 15.0
        ]);
    }

    public function test_can_delete_ige1()
    {
        IGE1::create([
            'Code' => 'TEST001',
            'LineId' => 0,
            'ItemCode' => 'A001',
            'Dscripcion' => 'Articulo de prueba',
            'Quantity' => 10.5,
            'WhsCode' => 'WH01'
        ]);

        $response = $this->deleteJson('/api/ige1/TEST001/0');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('ige1', [
            'Code' => 'TEST001',
            'LineId' => 0
        ]);
    }

    public function test_returns_404_when_ige1_not_found()
    {
        $response = $this->getJson('/api/ige1/TEST001/999');

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'No encontrado'
            ]);
    }
}