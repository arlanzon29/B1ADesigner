<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OITW;

class OITWApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_oitw_by_key()
    {
        OITW::create([
            'ItemCode' => 'ITEM001',
            'WhsCode' => 'WH01',
            'OnHand' => 50
        ]);

        $response = $this->getJson('/api/oitw/ITEM001/WH01');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'ItemCode' => 'ITEM001',
                    'WhsCode' => 'WH01'
                ]
            ]);
    }

    public function test_can_get_all_oitw_by_itemcode()
    {
        OITW::create([
            'ItemCode' => 'ITEM002',
            'WhsCode' => 'WH01',
            'OnHand' => 100
        ]);

        $response = $this->getJson('/api/oitw/ITEM002');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_can_create_oitw()
    {
        $data = [
            'ItemCode' => 'ITEM003',
            'WhsCode' => 'WH01',
            'OnHand' => 25
        ];

        $response = $this->postJson('/api/oitw', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oitw', ['ItemCode' => 'ITEM003', 'WhsCode' => 'WH01']);
    }

    public function test_can_update_oitw()
    {
        OITW::create([
            'ItemCode' => 'ITEM004',
            'WhsCode' => 'WH01',
            'OnHand' => 10
        ]);

        $data = [
            'ItemCode' => 'ITEM004',
            'WhsCode' => 'WH01',
            'OnHand' => 75
        ];

        $response = $this->putJson('/api/oitw/ITEM004/WH01', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('oitw', [
            'ItemCode' => 'ITEM004',
            'WhsCode' => 'WH01',
            'OnHand' => 75
        ]);
    }

    public function test_can_delete_oitw()
    {
        OITW::create([
            'ItemCode' => 'ITEM005',
            'WhsCode' => 'WH01',
            'OnHand' => 5
        ]);

        $response = $this->deleteJson('/api/oitw/ITEM005/WH01');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('oitw', ['ItemCode' => 'ITEM005', 'WhsCode' => 'WH01']);
    }
}