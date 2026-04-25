<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OITM;

class OITMApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_oitm_by_key()
    {
        OITM::create([
            'ItemCode' => 'ITEM001',
            'ItemName' => 'Articulo prueba',
            'OnHand' => 10
        ]);

        $response = $this->getJson('/api/oitm/ITEM001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'ItemCode' => 'ITEM001'
                ]
            ]);
    }

    public function test_can_create_oitm()
    {
        $data = [
            'ItemCode' => 'ITEM002',
            'ItemName' => 'Articulo nuevo',
            'OnHand' => 5
        ];

        $response = $this->postJson('/api/oitm', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oitm', ['ItemCode' => 'ITEM002']);
    }

    public function test_can_update_oitm()
    {
        OITM::create([
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo original',
            'OnHand' => 1
        ]);

        $data = [
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo actualizado',
            'OnHand' => 20
        ];

        $response = $this->putJson('/api/oitm/ITEM003', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oitm', [
            'ItemCode' => 'ITEM003',
            'ItemName' => 'Articulo actualizado'
        ]);
    }

    public function test_can_delete_oitm()
    {
        OITM::create([
            'ItemCode' => 'ITEM004',
            'ItemName' => 'Articulo a eliminar',
            'OnHand' => 1
        ]);

        $response = $this->deleteJson('/api/oitm/ITEM004');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('oitm', ['ItemCode' => 'ITEM004']);
    }

    public function test_can_search_oitm()
    {
        OITM::create([
            'ItemCode' => 'ITEM005',
            'ItemName' => 'Articulo buscar',
            'OnHand' => 1
        ]);

        $response = $this->getJson('/api/oitm?ItemCode=ITEM005');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_returns_404_when_oitm_not_found()
    {
        $response = $this->getJson('/api/oitm/NONEXISTENT');

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'message' => 'No encontrado'
            ]);
    }
}