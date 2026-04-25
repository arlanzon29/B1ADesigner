<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OITT;

class OITTApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_oitt_by_key()
    {
        OITT::create([
            'Code' => 'LIST001',
            'ItemCode' => 'ITEM001',
            'ItemName' => 'Articulo prueba',
            'Quantity' => 1
        ]);

        $response = $this->getJson('/api/oitt/LIST001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'Code' => 'LIST001',
                    'ItemCode' => 'ITEM001'
                ]
            ]);
    }

    public function test_can_create_oitt()
    {
        $data = [
            'Code' => 'LIST002',
            'ItemCode' => 'ITEM002',
            'ItemName' => 'Articulo nuevo',
            'Quantity' => 2
        ];

        $response = $this->postJson('/api/oitt', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oitt', ['Code' => 'LIST002']);
    }

    public function test_can_update_oitt()
    {
        OITT::create([
            'Code' => 'LIST003',
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo original',
            'Quantity' => 1
        ]);

        $data = [
            'Code' => 'LIST003',
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo actualizado',
            'Quantity' => 5
        ];

        $response = $this->putJson('/api/oitt/LIST003', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oitt', [
            'Code' => 'LIST003',
            'ItemName' => 'Articulo actualizado'
        ]);
    }

    public function test_can_delete_oitt()
    {
        OITT::create([
            'Code' => 'LIST004',
            'ItemCode' => 'ITEM004',
            'ItemName' => 'Articulo a eliminar',
            'Quantity' => 1
        ]);

        $response = $this->deleteJson('/api/oitt/LIST004');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('oitt', ['Code' => 'LIST004']);
    }

    public function test_can_search_oitt_by_item_code()
    {
        OITT::create([
            'Code' => 'LIST005',
            'ItemCode' => 'ITEM005',
            'ItemName' => 'Articulo buscar',
            'Quantity' => 1
        ]);

        $response = $this->get('/api/oitt?itemCode=ITEM005');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_returns_404_when_oitt_not_found()
    {
        $response = $this->getJson('/api/oitt/NONEXISTENT');

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'No encontrado'
            ]);
    }
}