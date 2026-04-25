---
name: componente-php
description: Sirve para crear componentes Laravel siguiendo un pseudocódigo
---

# Normas para la creación de un componente Laravel

## Índice

1. [Nomenclatura y normas generales](#1-nomenclatura-y-normas-generales)
2. [Archivos a crear por tipo](#2-archivos-a-crear-por-tipo)
3. [Modelo de Datos](#3-modelo-de-datos)
4. [Interfaces y Repositorios](#4-interfaces-y-repositorios)
5. [Controladores y Rutas](#5-controladores-y-rutas)
6. [Servicios y Transacciones](#6-servicios-y-transacciones)
7. [Claves Primarias Compuestas](#7-claves-primarias-compuestas)
8. [AppServiceProvider](#8-appserviceprovider)
9. [Testing con PHPUnit](#9-testing-con-phpunit)

---

## 1. Nomenclatura y normas generales

### Modelos Eloquent
- Los **modelos Eloquent** deben usar nombres en **mayúsculas** (ej: `OITT`, `ITT1`, `OITM`)
- Los nombres de archivos de modelos deben respetar ese mismo case (ej: `OITT.php`, `OITM.php`)
- Añadir `public $timestamps = false;` si la tabla no tiene `created_at` / `updated_at`

### Interfaces
- Las interfaces usan el **mismo case que el modelo** al que pertenecen
  - Modelo `OITM` → interfaz `IOITMRepository`
  - Modelo `Oitm` (PascalCase normal) → interfaz `IOitmRepository`
- Las **interfaces de tablas de BD** van en `app/Interfaces/` con prefijo `I` + nombre tabla
- Las **interfaces de pantallas** van en `app/InterfacesForm/` con el nombre completo de la pantalla

### Pantallas
- Usar siempre el **nombre completo de la pantalla**, no solo el número:
  - ✅ Correcto: `IFrm012fichaArticuloRepository.php`
  - ❌ Incorrecto: `IFrm012Repository.php`

### Rutas API
- Todas las rutas se definen en `routes/api.php` y Laravel las publica bajo el prefijo `/api/`
- Las rutas usan el nombre completo de la pantalla:
  - `/frm010consultaarticulos` → Pantalla de consulta
  - `/frm012fichaarticulo` → Pantalla de ficha

### Métodos y respuestas
- **Todos los métodos devuelven un array** con la siguiente estructura:

```php
return [
    'success' => true|false,
    'data'    => $modelo|null,
    'message' => 'Texto descriptivo'
];
```

- El **método Patch** usa `Illuminate\Http\Request` para recibir campos opcionales a actualizar
- Siempre generar un **docblock** con la especificación del pseudocódigo y descripción de parámetros

---

## 2. Archivos a crear por tipo

### Para tablas de base de datos

| Archivo | Ubicación |
|---|---|
| Migración | `database/migrations/xxxx_create_[tabla]_table.php` |
| Modelo | `app/Models/[Nombre].php` |
| Interfaz | `app/Interfaces/I[Nombre]Repository.php` |
| Repositorio | `app/Repositories/[Nombre]Repository.php` |
| Controlador | `app/Http/Controllers/[Nombre]Controller.php` |
| Rutas | `routes/api.php` (import del controlador + rutas) |
| Binding | `app/Providers/AppServiceProvider.php` |
| Test | `tests/Feature/[Nombre]ApiTest.php` |

### Para pantallas (sin tabla de BD propia)

| Archivo | Ubicación |
|---|---|
| Modelos de pantalla | `app/ModelsForms/[FrmXXXCompleto]Models.php` |
| Interfaz | `app/InterfacesForm/I[FrmXXXCompleto]Repository.php` |
| Repositorio | `app/RepositoriesForm/[FrmXXXCompleto]Repository.php` |
| Controlador | `app/Http/Controllers/[FrmXXXCompleto]Controller.php` |
| Rutas | `routes/api.php` |
| Binding | `app/Providers/AppServiceProvider.php` |

### Para servicios (lógica de negocio)

| Archivo | Ubicación |
|---|---|
| Especificación | `especificaciones/servicios/[NombreServicio].md` |
| Modelo request | `app/ModelsService/[Nombre]Request.php` |
| Interfaz | `app/InterfacesService/I[Nombre]Service.php` |
| Implementación | `app/services/[Nombre]Service.php` |
| Controlador | `app/Http/Controllers/[Nombre]Controller.php` |
| Rutas | `routes/api.php` |
| Binding | `app/Providers/AppServiceProvider.php` |

---

## 3. Modelo de Datos

**IMPORTANTE**: Los nombres de las columnas deben respetar **fielmente** los nombres especificados en el pseudocódigo. No usar snake_case automáticamente.

### Pseudocódigo → Migración

```
Oitm: Objeto
- ItemCode: String(50)
- ItemName: String(200)
- OnHand: Decimal
```

Se traduce a:

```php
Schema::create('oitm', function (Blueprint $table) {
    $table->string('ItemCode', 50)->primary();
    $table->string('ItemName', 200);
    $table->decimal('OnHand', 10, 2)->default(0);
});
```

### Tipos de datos

| Pseudocódigo | Laravel |
|---|---|
| `String(N)` | `$table->string('nombre', N)` |
| `Decimal` | `$table->decimal('nombre', 10, 2)` |
| `DateTime` | `$table->dateTime('nombre')` |
| `Int` | `$table->integer('nombre')` |

### Modelo Eloquent (tabla BD)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OITM extends Model
{
    protected $table = 'oitm';
    protected $primaryKey = 'ItemCode';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'ItemCode',
        'ItemName',
        'OnHand',
    ];

    protected $casts = [
        'OnHand' => 'decimal:2',
    ];
}
```

### Modelos de Pantalla (ModelsForms)

Para modelos de pantalla que no corresponden a una tabla de BD, usar la carpeta `app/ModelsForms/`.

**Nomenclatura:**
- `unboundFrm010consultaarticulos` → modelo de filtros/datos de entrada
- `dbgArticulosFrm010consultaarticulos` → modelo de lista para grids

```php
<?php

namespace App\ModelsForms;

// Filtro de entrada
class unboundFrm010consultaarticulos
{
    public ?string $ItemCode = null;

    public function __construct(?string $ItemCode = null)
    {
        $this->ItemCode = $ItemCode;
    }
}

// Lista para grid
class dbgArticulosFrm010consultaarticulos
{
    public string $ItemCode;
    public string $ItemName;
    public float $OnHand;

    public function __construct(string $ItemCode = '', string $ItemName = '', float $OnHand = 0)
    {
        $this->ItemCode = $ItemCode;
        $this->ItemName = $ItemName;
        $this->OnHand = $OnHand;
    }
}
```

---

## 4. Interfaces y Repositorios

### Interfaz básica (tabla de BD)

```php
<?php

namespace App\Interfaces;

use App\Models\OITM;

interface IOITMRepository
{
    /**
     * Añade un artículo.
     *
     * @param OITM $elemento
     * @return array ['success', 'data', 'message']
     */
    public function add(OITM $elemento): array;

    /**
     * Obtiene un artículo por su clave primaria.
     *
     * @param string $itemCode
     * @return array ['success', 'data', 'message']
     */
    public function getByKey(string $itemCode): array;
}
```

### Repositorio básico (tabla de BD)

```php
<?php

namespace App\Repositories;

use App\Interfaces\IOITMRepository;
use App\Models\OITM;

class OITMRepository implements IOITMRepository
{
    /**
     * Añade un artículo.
     */
    public function add(OITM $elemento): array
    {
        try {
            $elemento->save();
            return ['success' => true, 'data' => $elemento, 'message' => 'Elemento guardado correctamente'];
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error al guardar: ' . $e->getMessage()];
        }
    }

    /**
     * Obtiene un artículo por su clave primaria.
     */
    public function getByKey(string $itemCode): array
    {
        $elemento = OITM::find($itemCode);
        if (!$elemento) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => $elemento, 'message' => 'OK'];
    }
}
```

### Método Patch

```php
// Interfaz
/**
 * Actualiza parcialmente un artículo.
 *
 * @param Request $request campos opcionales (ItemName, OnHand)
 * @param string $itemCode
 * @return array ['success', 'data', 'message']
 */
public function patch(Request $request, string $itemCode): array;

// Repositorio
public function patch(Request $request, string $itemCode): array
{
    $elemento = OITM::find($itemCode);
    if (!$elemento) {
        return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
    }

    if ($request->has('ItemName')) {
        $elemento->ItemName = $request->input('ItemName');
    }
    if ($request->has('OnHand')) {
        $elemento->OnHand = $request->input('OnHand');
    }

    $elemento->save();
    return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado correctamente'];
}

// Controlador
public function patch(Request $request, string $itemCode)
{
    return $this->repository->patch($request, $itemCode);
}
```

### Interfaz de pantalla (Form)

```php
<?php

namespace App\InterfacesForm;

use App\ModelsForms\unboundFrm010consultaarticulos;

interface IFrm010consultaArticulosRepository
{
    public function crearFiltro(array $datos): unboundFrm010consultaarticulos;
    public function consultarArticulos(unboundFrm010consultaarticulos $filtro): array;
}
```

### Repositorio de pantalla: mapeo Request → Unbound

```php
// Repositorio
public function crearFiltro(array $datos): unboundFrm010consultaarticulos
{
    return new unboundFrm010consultaarticulos($datos['ItemCode'] ?? null);
}

// Controlador
public function consultar(Request $request)
{
    $filtro = $this->repository->crearFiltro($request->all());
    return $this->repository->consultarArticulos($filtro);
}
```

### SQL en el Repositorio

**SQL sencilla** (JOIN simple, WHERE, ORDER BY) → Query Builder con `map`:

```php
$resultados = DB::table('oitm')
    ->select('ItemCode', 'ItemName', 'OnHand')
    ->where('ItemCode', 'like', $filtro->ItemCode . '%')
    ->get()
    ->map(function ($item) {
        return new dbgArticulosFrm010consultaarticulos(
            $item->ItemCode,
            $item->ItemName,
            $item->OnHand
        );
    });
```

**SQL compleja** (subconsultas, funciones agregadas) → `DB::select` con mapeo manual:

```php
$sql = "SELECT ItemCode, (SELECT MAX(OnHand) FROM oitw WHERE ItemCode = o.ItemCode) AS MaxStock
        FROM oitm o WHERE ItemCode LIKE ?";

$resultados = DB::select($sql, [$filtro->ItemCode . '%']);

$lista = [];
foreach ($resultados as $item) {
    $lista[] = new dbgArticulosFrm010consultaarticulos($item->ItemCode, '', $item->MaxStock);
}
```

---

## 5. Controladores y Rutas

### Ficha (pantalla de detalle) → GET con query string

```php
// routes/api.php
use App\Http\Controllers\Frm012fichaArticuloController;

Route::get('/frm012fichaarticulo', [Frm012fichaArticuloController::class, 'getByKey']);

// Controlador
public function getByKey(Request $request)
{
    $itemCode = $request->query('itemCode');
    return $this->repository->getByKey($itemCode);
}
```

### Consulta (pantalla de lista) → POST con modelo Unbound

```php
// routes/api.php
use App\Http\Controllers\Frm010consultaArticulosController;

Route::post('/frm010consultaarticulos', [Frm010consultaArticulosController::class, 'consultar']);

// Controlador
public function consultar(Request $request)
{
    $filtro = $this->repository->crearFiltro($request->all());
    return $this->repository->consultarArticulos($filtro);
}
```

### CRUD estándar (tabla de BD con clave simple)

```php
// routes/api.php
Route::get('/oitm/{itemCode}',    [OITMController::class, 'getByKey']);
Route::post('/oitm',              [OITMController::class, 'add']);
Route::put('/oitm/{itemCode}',    [OITMController::class, 'update']);
Route::patch('/oitm/{itemCode}',  [OITMController::class, 'patch']);
Route::delete('/oitm/{itemCode}', [OITMController::class, 'delete']);
```

---

## 6. Servicios y Transacciones

### Tipos de servicio y uso de transacciones

| Tipo | Descripción | Necesita Transacción |
|---|---|---|
| **Repository** | CRUD básico de una tabla | ✗ No |
| **Service simple** | Coordina una sola tabla | ✗ No |
| **Service principal** | Coordina múltiples tablas | ✓ Sí |
| **Service de consulta** | Solo lectura | ✗ No |

### Indicación en la especificación

En `especificaciones/servicios/[Nombre].md`, indicar explícitamente:

```
## Servicios
- Crear: Entrada(...) -> Salida(...), Transacción: Sí
- Buscar: Entrada(...) -> Salida(...), Transacción: No
```

Si la especificación indica `Transacción: Sí`, envolver el método en `DB::transaction()`.

### Ejemplo: Service principal con transacción

```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\OIGE;
use App\Models\IGE1;
use App\Models\OITM;

class OigeService implements IOigeService
{
    public function crear(OigeServiceRequest $request): array
    {
        try {
            return DB::transaction(function () use ($request) {
                // 1. Validar artículos
                foreach ($request->Lineas as $linea) {
                    $item = OITM::find($linea->ItemCode);
                    if (!$item) {
                        return ['success' => false, 'data' => null, 'message' => 'Artículo no encontrado'];
                    }
                }

                // 2. Crear cabecera
                $cabecera = new OIGE();
                $cabecera->Code    = $request->Code;
                $cabecera->DocDate = $request->DocDate;
                $cabecera->save();

                // 3. Crear líneas y actualizar stocks
                $lineId = 1;
                foreach ($request->Lineas as $linea) {
                    $ige1           = new IGE1();
                    $ige1->Code     = $cabecera->Code;
                    $ige1->LineId   = $lineId;
                    $ige1->ItemCode = $linea->ItemCode;
                    $ige1->save();

                    // Actualizar stock en OITM
                    OITM::where('ItemCode', $linea->ItemCode)
                        ->decrement('OnHand', $linea->Quantity);

                    $lineId++;
                }

                return ['success' => true, 'data' => $cabecera, 'message' => 'Creado correctamente'];
            });
        } catch (\Exception $e) {
            return ['success' => false, 'data' => null, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
```

### Tests de servicios

Los tests unitarios llaman directamente al Service (sin pasar por el Controller):

```php
$service = new OigeService(/* inyectar dependencias si las hay */);
$result  = $service->crear($request);

$this->assertTrue($result['success']);
```

---

## 7. Claves Primarias Compuestas

Para tablas con clave primaria compuesta (ej: `ITT1`, `CRD1`, `OITW`, `IGE1`), Eloquent no gestiona bien `save()` y `delete()` con claves en array.

**Regla**: usar `DB::table()` o Eloquent Query Builder (`::where()`) en lugar de `save()` / `delete()` para update y delete.

### Modelo con clave compuesta

```php
class IGE1 extends Model
{
    protected $table      = 'ige1';
    protected $primaryKey = ['Code', 'LineId'];
    public $incrementing  = false;
    public $timestamps    = false;

    protected $fillable = ['Code', 'LineId', 'ItemCode', 'Quantity', 'WhsCode'];
}
```

### Método update

```php
public function update(IGE1 $elemento): array
{
    try {
        $actualizado = IGE1::where('Code', $elemento->Code)
            ->where('LineId', $elemento->LineId)
            ->update([
                'ItemCode' => $elemento->ItemCode,
                'Quantity' => $elemento->Quantity,
                'WhsCode'  => $elemento->WhsCode,
            ]);

        if ($actualizado === 0) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado correctamente'];
    } catch (\Exception $e) {
        return ['success' => false, 'data' => null, 'message' => 'Error al actualizar: ' . $e->getMessage()];
    }
}
```

### Método delete

```php
public function delete(string $code, int $lineId): array
{
    try {
        $eliminado = IGE1::where('Code', $code)->where('LineId', $lineId)->delete();

        if ($eliminado === 0) {
            return ['success' => false, 'data' => null, 'message' => 'No encontrado'];
        }
        return ['success' => true, 'data' => null, 'message' => 'Eliminado correctamente'];
    } catch (\Exception $e) {
        return ['success' => false, 'data' => null, 'message' => 'Error al eliminar: ' . $e->getMessage()];
    }
}
```

### Rutas y controlador con clave compuesta

```php
// routes/api.php
Route::get('/ige1/{code}/{lineId}',    [IGE1Controller::class, 'getByKey']);
Route::put('/ige1/{code}/{lineId}',    [IGE1Controller::class, 'update']);
Route::delete('/ige1/{code}/{lineId}', [IGE1Controller::class, 'delete']);

// Controlador
public function getByKey(string $code, int $lineId)
{
    return $this->repository->getByKey($code, $lineId);
}

public function update(Request $request, string $code, int $lineId)
{
    $elemento          = new IGE1();
    $elemento->Code    = $code;
    $elemento->LineId  = $lineId;
    $elemento->ItemCode = $request->input('ItemCode');
    $elemento->Quantity = $request->input('Quantity');
    $elemento->WhsCode  = $request->input('WhsCode');
    return $this->repository->update($elemento);
}

public function delete(string $code, int $lineId)
{
    return $this->repository->delete($code, $lineId);
}
```

### Errores comunes si no se sigue esta norma

| Error | Causa |
|---|---|
| `Illegal offset type` | Usar `save()` en modelo con clave compuesta |
| `null given` | Parámetros de ruta mal tipados en el controller |
| `Foreign key constraint failed` | Tests sin datos relacionados creados previamente |

---

## 8. AppServiceProvider

Registrar el binding interfaz → repositorio en `app/Providers/AppServiceProvider.php`, dentro del método `register()`.

**IMPORTANTE**: incluir siempre los `use` imports en la parte superior del archivo.

### Para tablas de BD (`app/Interfaces/`)

```php
use App\Interfaces\IOITMRepository;
use App\Repositories\OITMRepository;

public function register(): void
{
    $this->app->bind(IOITMRepository::class, OITMRepository::class);
}
```

### Para pantallas (`app/InterfacesForm/`)

```php
use App\InterfacesForm\IFrm012fichaArticuloRepository;
use App\RepositoriesForm\Frm012fichaArticuloRepository;

public function register(): void
{
    $this->app->bind(IFrm012fichaArticuloRepository::class, Frm012fichaArticuloRepository::class);
}
```

### Para servicios (`app/InterfacesService/`)

```php
use App\InterfacesService\IOigeService;
use App\Services\OigeService;

public function register(): void
{
    $this->app->bind(IOigeService::class, OigeService::class);
}
```

---

## 9. Testing con PHPUnit

### Estructura de un test de API

```php
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\OITM;

class OITMApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_oitm_by_key(): void
    {
        OITM::create([
            'ItemCode' => 'ITEM001',
            'ItemName' => 'Artículo prueba',
            'OnHand'   => 10,
        ]);

        $response = $this->getJson('/api/oitm/ITEM001');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => ['ItemCode' => 'ITEM001'],
            ]);
    }

    public function test_can_create_oitm(): void
    {
        $data = [
            'ItemCode' => 'ITEM002',
            'ItemName' => 'Artículo nuevo',
            'OnHand'   => 5,
        ];

        $response = $this->postJson('/api/oitm', $data);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('oitm', ['ItemCode' => 'ITEM002']);
    }

    public function test_returns_error_when_not_found(): void
    {
        $response = $this->getJson('/api/oitm/NOEXISTE');

        $response->assertStatus(200)
            ->assertJson(['success' => false]);
    }
}
```

### Test con clave primaria compuesta

```php
public function test_can_get_ige1_by_composite_key(): void
{
    // Crear primero la cabecera (FK obligatoria)
    OIGE::create(['Code' => 'GE001', 'DocDate' => now()]);

    IGE1::create([
        'Code'     => 'GE001',
        'LineId'   => 1,
        'ItemCode' => 'ITEM001',
        'Quantity' => 3,
    ]);

    $response = $this->getJson('/api/ige1/GE001/1');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data'    => ['Code' => 'GE001', 'LineId' => 1],
        ]);
}
```

### Test de servicio (sin Controller)

```php
public function test_oige_service_crear(): void
{
    $service = app(IOigeService::class);

    $request           = new OigeServiceRequest();
    $request->Code     = 'GE001';
    $request->DocDate  = now()->toDateString();
    $request->Lineas   = [];

    $result = $service->crear($request);

    $this->assertTrue($result['success']);
    $this->assertDatabaseHas('oige', ['Code' => 'GE001']);
}
```

### Normas para tests

- Usar `RefreshDatabase` en cada clase de test
- Crear siempre los datos relacionados (FK) antes que el registro principal
- Verificar con `assertJson`, `assertDatabaseHas` y `assertDatabaseMissing`
- Respetar el case exacto de los mensajes en `assertJson`
- Incluir todos los campos obligatorios del modelo al crear datos de prueba

### Ejecución

```bash
php artisan test                          # Todos los tests
php artisan test --filter=OITMApiTest     # Solo tests de OITM
php artisan test --filter=IGE1ApiTest     # Solo tests de IGE1
```
