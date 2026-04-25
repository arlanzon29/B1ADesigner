<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ITT1;

class ITT1ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_itt1_by_key()
    {
        ITT1::create([
            'Code' => 'LIST001',
            'LineId' => 1,
            'ItemCode' => 'ITEM001',
            'ItemName' => 'Articulo consume',
            'Quantity' => 2
        ]);

        $response = $this->getJson('/api/itt1/LIST001/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Code' => 'LIST001',
                    'LineId' => 1
                ]
            ]);
    }

    public function test_can_create_itt1()
    {
        $data = [
            'Code' => 'LIST002',
            'LineId' => 1,
            'ItemCode' => 'ITEM002',
            'ItemName' => 'Articulo nuevo',
            'Quantity' => 3
        ];

        $response = $this->postJson('/api/itt1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('itt1', [
            'Code' => 'LIST002',
            'LineId' => 1
        ]);
    }

    public function test_can_update_itt1()
    {
        ITT1::create([
            'Code' => 'LIST003',
            'LineId' => 1,
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo original',
            'Quantity' => 1
        ]);

        $data = [
            'Code' => 'LIST003',
            'LineId' => 1,
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo actualizado',
            'Quantity' => 5
        ];

        $response = $this->putJson('/api/itt1/LIST003/1', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('itt1', [
            'Code' => 'LIST003',
            'LineId' => 1,
            'ItemName' => 'Articulo actualizado'
        ]);
    }

    public function test_can_delete_itt1()
    {
        ITT1::create([
            'Code' => 'LIST004',
            'LineId' => 1,
            'ItemCode' => 'ITEM004',
            'ItemName' => 'Articulo a eliminar',
            'Quantity' => 1
        ]);

        $response = $this->deleteJson('/api/itt1/LIST004/1');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('itt1', [
            'Code' => 'LIST004',
            'LineId' => 1
        ]);
    }

    public function test_can_search_itt1_by_code()
    {
        ITT1::create([
            'Code' => 'LIST005',
            'LineId' => 1,
            'ItemCode' => 'ITEM005',
            'ItemName' => 'Articulo buscar',
            'Quantity' => 1
        ]);

        $response = $this->getJson('/api/itt1/search?code=LIST005');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }
}