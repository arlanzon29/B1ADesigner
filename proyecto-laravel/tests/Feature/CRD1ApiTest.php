<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\CRD1;

class CRD1ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_crd1_by_key()
    {
        CRD1::create([
            'CardCode' => 'C001',
            'LineId' => 1,
            'Address' => 'Direccion 1',
            'City' => 'Madrid'
        ]);

        $response = $this->getJson('/api/crd1/C001/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'CardCode' => 'C001',
                    'LineId' => 1
                ]
            ]);
    }

    public function test_can_get_all_crd1_by_cardcode()
    {
        CRD1::create([
            'CardCode' => 'C002',
            'LineId' => 1,
            'Address' => 'Direccion 1',
            'City' => 'Barcelona'
        ]);

        $response = $this->getJson('/api/crd1/C002');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_can_create_crd1()
    {
        $data = [
            'CardCode' => 'C003',
            'LineId' => 1,
            'Address' => 'Direccion nueva',
            'City' => 'Sevilla'
        ];

        $response = $this->postJson('/api/crd1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('crd1', ['CardCode' => 'C003', 'LineId' => 1]);
    }

    public function test_can_update_crd1()
    {
        CRD1::create([
            'CardCode' => 'C004',
            'LineId' => 1,
            'Address' => 'Direccion original',
            'City' => 'Valencia'
        ]);

        $data = [
            'CardCode' => 'C004',
            'LineId' => 1,
            'Address' => 'Direccion actualizada',
            'City' => 'Valencia'
        ];

        $response = $this->putJson('/api/crd1/C004/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_can_delete_crd1()
    {
        CRD1::create([
            'CardCode' => 'C005',
            'LineId' => 1,
            'Address' => 'Direccion a eliminar',
            'City' => 'Bilbao'
        ]);

        $response = $this->deleteJson('/api/crd1/C005/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }
}