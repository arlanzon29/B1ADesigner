<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OITM;
use App\Models\OWHS;
use App\Models\OITW;
use App\ModelsService\OigeServiceRequest;
use App\ModelsService\OigeServiceLinea;
use App\Services\OigeService;

class OigeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        OITM::create([
            'ItemCode' => 'A001',
            'ItemName' => 'Articulo prueba 1',
            'OnHand' => 0
        ]);
        OITM::create([
            'ItemCode' => 'A002',
            'ItemName' => 'Articulo prueba 2',
            'OnHand' => 0
        ]);
        OWHS::create([
            'WhsCode' => 'WH01',
            'WhsName' => 'Almacen 1'
        ]);
        OWHS::create([
            'WhsCode' => 'WH02',
            'WhsName' => 'Almacen 2'
        ]);
    }

    public function test_can_create_transaction()
    {
        $lineas = [
            new OigeServiceLinea('A001', 'Articulo 1', 10.5, 'WH01'),
            new OigeServiceLinea('A002', 'Articulo 2', 20.0, 'WH02')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $result = $service->crear($request);

        $this->assertTrue($result['success']);
        $this->assertDatabaseHas('oige', ['Code' => 'TEST001']);
        $this->assertDatabaseHas('ige1', ['Code' => 'TEST001', 'LineId' => 1, 'ItemCode' => 'A001']);
        $this->assertDatabaseHas('ige1', ['Code' => 'TEST001', 'LineId' => 2, 'ItemCode' => 'A002']);
    }

    public function test_updates_stock_on_oitm()
    {
        $lineas = [
            new OigeServiceLinea('A001', 'Articulo 1', 10.5, 'WH01')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $service->crear($request);

        $item = OITM::find('A001');
        $this->assertEquals(10.5, $item->OnHand);
    }

    public function test_creates_stock_on_oitw()
    {
        $lineas = [
            new OigeServiceLinea('A001', 'Articulo 1', 10.5, 'WH01')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $service->crear($request);

        $this->assertDatabaseHas('oitw', [
            'ItemCode' => 'A001',
            'WhsCode' => 'WH01',
            'OnHand' => 10.5
        ]);
    }

    public function test_increments_existing_stock_on_oitw()
    {
        OITW::create([
            'ItemCode' => 'A001',
            'WhsCode' => 'WH01',
            'OnHand' => 5.0
        ]);

        $lineas = [
            new OigeServiceLinea('A001', 'Articulo 1', 10.5, 'WH01')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $service->crear($request);

        $stock = OITW::where('ItemCode', 'A001')->where('WhsCode', 'WH01')->first();
        $this->assertEquals(15.5, $stock->OnHand);
    }

    public function test_returns_error_when_item_not_found()
    {
        $lineas = [
            new OigeServiceLinea('INVALID', 'Articulo invalido', 10.5, 'WH01')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $result = $service->crear($request);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Artículo no encontrado', $result['message']);
    }

    public function test_returns_error_when_warehouse_not_found()
    {
        $lineas = [
            new OigeServiceLinea('A001', 'Articulo 1', 10.5, 'INVALID')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $result = $service->crear($request);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Almacén no encontrado', $result['message']);
    }

    public function test_lineid_starts_at_1()
    {
        $lineas = [
            new OigeServiceLinea('A001', 'Articulo 1', 10.5, 'WH01'),
            new OigeServiceLinea('A002', 'Articulo 2', 20.0, 'WH02')
        ];

        $request = new OigeServiceRequest('TEST001', '2026-04-25', $lineas);

        $service = new OigeService();
        $service->crear($request);

        $this->assertDatabaseHas('ige1', ['Code' => 'TEST001', 'LineId' => 1]);
        $this->assertDatabaseHas('ige1', ['Code' => 'TEST001', 'LineId' => 2]);
    }
}