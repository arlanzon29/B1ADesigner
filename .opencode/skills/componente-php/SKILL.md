---
name: componente-php
description: Sirve para crear componentes Laravel siguiendo un pseudocodigo
---

# Normas para la creación de un componente Laravel

- **Los modelos Eloquent deben usar nombres en mayúsculas** (ej: `OITT`, `ITT1`, `OITM`)
- **Los nombres de interfaces deben seguir el mismo caso que el modelo** (ej: `IOITMRepository`, `IOITTRepository`)
- Los nombres de archivos de modelos deben usar mayúsculas (ej: `OITT.php`, `ITT1.php`)
- El objetivo es fixer una serie de normas para poder generar código PHP/Laravel a partir de un pseudocódigo
- Las rutas API deben usar el nombre completo de la pantalla (ej: `frm012ficharticulo`) para mantener consistencia
- Para claves primarias compuestas, usar `DB::table()` en los métodos update y delete del repositorio (NO usar Eloquent save/delete)
- Para cada tabla se deben crear los siguientes archivos:
    1. **Migración** en `database/migrations/`
    2. **Modelo** en `app/Models/`
    3. **Interfaz** en `app/Interfaces/` (para tablas de BD)
    4. **Repositorio** en `app/Repositories/` (para tablas de BD)
    5. **Controlador** en `app/Http/Controllers/`
    6. **Rutas API** en `routes/api.php` (incluir import del controlador y nombre completo de pantalla)
    7. **ServiceProvider** registrar el binding de la interfaz al repositorio en `app/Providers/AppServiceProvider.php`
    8. **Test** en `tests/Feature/<Tabla>ApiTest.php`

- Las **interfaces de tablas de BD** van en `app/Interfaces/` con prefijo `I` + nombre tabla (ej: `IOITMRepository`)
- Las **interfaces de pantallas** van en `app/InterfacesForm/` con nombre completo (ej: `IFrm012fichaArticuloRepository`)
- Los **repositorios de pantallas** van en `app/RepositoriesForm/`
- Los **modelos de pantallas** van en `app/ModelsForm/`

## Nomenclatura de archivos

**IMPORTANTE**: Usar el nombre completo de la pantalla (no solo el número):
- Correcto: `IFrm012fichaArticuloRepository.php`
- Incorrecto: `IFrm012Repository.php`

## Nomenclatura de rutas

Usar el nombre completo de la pantalla:
```
/frm010consultaarticulos      → Pantalla de consulta
/frm012fichaarticulo         → Pantalla de ficha (nombre completo)
```

**Fichas** (pantallas de detalle): Usan GET con query string
```php
Route::get('/frm012fichaarticulo', [Frm012fichaArticuloController::class, 'getByKey']);

// Controller
public function getByKey(Request $request)
{
    $itemCode = $request->query('itemCode');
    return $repository->getByKey($itemCode);
}
```

**Consultas** (pantallas de lista): Usan POST con modelo Unbound
```php
Route::post('/frm010consultaarticulos', [Frm010consultaArticulosController::class, 'consultar']);

// Controller
public function consultar(Request $request)
{
    $filtro = $this->repository->crearFiltro($request->all());
    return $this->repository->consultarArticulos($filtro);
}
```

**AppServiceProvider**: IMPORTANTE incluir los imports de los Repositorios
```php
use App\InterfacesForm\IFrm010consultaArticulosRepository;
use App\Repositories\Frm010consultaArticulosRepository;

$this->app->bind(IFrm010consultaArticulosRepository::class, Frm010consultaArticulosRepository::class);
```

## Archivos a crear

### Para tablas de base de datos
```
database/migrations/xxxx_create_[tabla]_table.php
app/Models/[Nombre].php
```

### Para pantallas (no BD)
```
app/ModelsForms/[FrmXXXCompleto]Models.php    // Modelos de pantalla
app/InterfacesForm/I[FrmXXXCompleto]Repository.php
app/Repositories/[FrmXXXCompleto]Repository.php
app/Http/Controllers/[FrmXXXCompleto]Controller.php
routes/api.php (incluir import del controlador)
app/Providers/AppServiceProvider.php (registrar binding)
```

### Para servicios (lógica de negocio)
```
especificaciones/servicios/[NombreServicio].md  // Especificación
app/ModelsService/[Nombre]Request.php           // Modelo de request
app/InterfacesService/I[Nombre]Service.php      // Interfaz del servicio
app/services/[Nombre]Service.php                // Implementación del servicio
app/Http/Controllers/[Nombre]Controller.php     // Controlador
routes/api.php (incluir import del controlador)
app/Providers/AppServiceProvider.php (registrar binding)
```

## Transacciones en Servicios

### Indicación en Especificación

En la especificación del servicio (`especificaciones/servicios/[Nombre].md`), indicar explícitamente si cada método usa transacción:

```
## Servicios
- Crear: Entrada(...) -> Salida(...), Transacción: Sí
- Buscar: Entrada(...) -> Salida(...), Transacción: No
```

**Al crear la implementación del servicio, si la especificación indica `Transacción: Sí`, envolver todo el método en `DB::transaction()`.**

### Tipos de Servicios

| Tipo | Descripción | Necesita Transacción |
|------|-------------|---------------------|
| **Simple** | CRUD básico de una sola tabla (Repository) | ✗ No |
| **Principal** | Coordina múltiples operaciones en varias tablas | ✓ Sí |
| **Consultas** | Solo lee datos | ✗ No |

### Norma General

- **Repository**: Nunca usa transacción
- **Service simple** (una tabla): Nunca usa transacción
- **Service principal** (múltiples tablas): Usa `DB::transaction()`

### Ejemplo Service Principal con Transacción

``` Codigo PHP/Laravel
use Illuminate\Support\Facades\DB;

class OigeService implements IOigeService
{
    public function crear(OigeServiceRequest $request): array
    {
        try {
            return DB::transaction(function () use ($request) {
                // 1. Validar artículos y almacenes
                foreach ($request->Lineas as $linea) {
                    $item = OITM::find($linea->ItemCode);
                    if (!$item) {
                        return ['success' => false, 'message' => 'Artículo no encontrado'];
                    }
                }

                // 2. Crear cabecera
                $cabecera = new OIGE();
                $cabecera->Code = $request->Code;
                $cabecera->DocDate = $request->DocDate;
                $cabecera->save();

                // 3. Crear líneas y actualizar stocks
                $lineId = 1;
                foreach ($request->Lineas as $linea) {
                    // Crear línea...
                    // Actualizar OITM.OnHand
                    // Actualizar OITW.OnHand
                    $lineId++;
                }

                return ['success' => true, 'data' => $cabecera];
            });
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
```

### Tests de Servicios

Los tests unitarios llaman directamente al Service (sin Controller):
``` Codigo PHP/Laravel
$service = new OigeService();
$result = $service->crear($request);

// Los tests funcionan porque el Service tiene la transacción integrada
```

## Diseño de Pantalla

### Cabecera de la página

Las páginas Laravel deben empezar siempre con la estructura básica de Blade.

Después viene el cuerpo.

### Bloque de controles de edición

Un bloque de control de edición se va a componer de un `<div>` que contiene una `<table>`.

Por ejemplo:
```
{div:Controles de edicion,data:unboundFrm010,tamaños:"100,200,300"}
Cliente|{txt:Cliente}|{txt:RazonSocial}
Articulo|{txt:Articulo}|{txt:Descripcion}
A Fecha|{txt:Fecha}|Tipo|{txt:Tipo}
{btn:Buscar}
```

En el ejemplo tenemos una tabla con 4 filas y 3 columnas.
- Los label normales son textos sin formato
- Los controles de edición se representan con la sintaxis {tipo:nombre} donde el tipo puede ser:
    - txt, campo de texto que se traduce por un input HTML
    - btn, es un botón que se traduce por un button
- Los campos se separan entre si por el caracter |


``` Codigo Blade/Laravel
<div style="margin:20px;background-color:#f0f0f0;padding:15px;">
  <h3 style="margin:5px">Controles de edicion</h3>
    <table>
        <colgroup>
            <col style="width:100px" />
            <col style="width:200px" />
            <col style="width:300px" />
        </colgroup>

        <!-- Fila 1: Cliente -->
        <tr>
            <td>Cliente</td>
            <td>
                <input type="text" wire:model="modeloUnbound.cliente" />
            </td>
            <td>
                <input type="text" wire:model="modeloUnbound.razonSocial" />
            </td>
        </tr>

        <!-- Fila 2: Articulo -->
        <tr>
            <td>Articulo</td>
            <td>
                <input type="text" wire:model="modeloUnbound.articulo" />
            </td>
            <td>
                <input type="text" wire:model="modeloUnbound.descripcion" />
            </td>
        </tr>

        <!-- Fila 3: A Fecha y Tipo -->
        <tr>
            <td>A Fecha</td>
            <td>
                <input type="date" wire:model="modeloUnbound.fecha" />
            </td>
            <td>
                Tipo
                <input type="text" wire:model="modeloUnbound.tipo" />
            </td>
        </tr>

        <!-- Fila 4: Botón Buscar -->
        <tr>
            <td colspan="3">
                <button wire:click="buscar">Buscar</button>
            </td>
        </tr>
    </table>
</div>
```

Los controles puede tener más atributos:
- colspan, el td al que pertenece el control tiene el colspan indicado.

- El div de un bloque de edición puede tener varias propiedades, por ejemplo tamaños
```
{div:Controles de edicion,data:unboundFrm010,tamaños:"100,200,300"}
```

### Bloque de tipo grid

Un bloque de tipo grid se compone de un `<div>` que contiene una tabla HTML.

Por ejemplo:

```
{grid:Datos Albaranes,data:dbgAlbaranes}
Cliente 		|Razón Social		|Articulo		|Descripcion		|Fecha		|Cantidad
{col:Cliente}	|{col:RazonSocial}	|{col:Articulo}	|{col:Descripcion}	|{col:Fecha}|{col:Cantidad }
```

En el ejemplo tenemos un grid con 6 columnas.

Este ejemplo se debe traducir a:

``` Codigo Blade/Laravel
<div style="overflow-x:auto;">
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Razón Social</th>
                <th>Articulo</th>
                <th>Descripcion</th>
                <th>Fecha</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dbgAlbaranes as $item)
            <tr>
                <td>{{ $item->cliente }}</td>
                <td>{{ $item->razonSocial }}</td>
                <td>{{ $item->articulo }}</td>
                <td>{{ $item->descripcion }}</td>
                <td>{{ $item->fecha }}</td>
                <td>{{ $item->cantidad }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

## Modelo de Datos

**IMPORTANTE**: Los nombres de las columnas deben respetar fielmente los nombres especificados en el MD. No usar snake_case.

Los bloques de datos van a contain la definición de los campos necesarios, se componen de Objetos con sus campos:

```
Oitm: Objeto
- ItemCode: String(50)
- ItemName: String(200)
- OnHand: Decimal
```
Oitm: Objeto
- ItemCode: String(50)
- ItemName: String(200)
- OnHand: Decimal
```

Se traduce a:

``` Codigo PHP/Laravel
Schema::create('oitm', function (Blueprint $table) {
    $table->string('ItemCode', 50)->primary();
    $table->string('ItemName', 200);
    $table->decimal('OnHand', 10, 2)->default(0);
});
```

Los tipos de datos son:
- string → `$table->string('nombre')`
- decimal → `$table->decimal('nombre', 10, 2)`
- DateTime → `$table->dateTime('nombre')`

Las clases se van a crear en PHP usando Eloquent:
- Los nombres de las clases usarán PascalCase
- Los nombres de los campos (propiedades) deben respetar fielmente el nombre indicado en el pseudocódigo
- Añadir `public $timestamps = false;` si la tabla no tiene `created_at`/`updated_at`

### Modelos de Pantalla (ModelsForms)

Para modelos de pantalla que no son de base de datos, usar carpeta `app/ModelsForms/`:

```
app/ModelsForms/
├── unboundFrm010consultaarticulos.php
└── dbgArticulosFrm010consultaarticulos.php
```

**Nomenclatura de clases:**
- `unboundFrm010consultaarticulos` - Modelo de filtros/datos de entrada
- `dbgArticulosFrm010consultaarticulos` - Modelo de lista para grids

**Ejemplo Frm010:**
``` Codigo PHP/Laravel
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

**En la interfaz:**
``` Codigo PHP/Laravel
namespace App\InterfacesForm;

use App\ModelsForms\Frm010Unbound;

interface IFrm010consultaArticulosRepository
{
    public function consultarArticulos(Frm010Unbound $filtro): array;
}
```

**Ejemplo correcto:**
- `IFrm010consultaArticulosRepository` (nombre completo)

**Ejemplo incorrecto:**
- `IFrm010Repository` (falta descripción)

### Mapeo Request a Unbound en Pantallas

Para pantallas, usar método en la interfaz para crear el modelo desde Request:

```php
// Interfaz
public function crearFiltro(array $datos): unboundFrm010consultaarticulos;

// Repositorio
public function crearFiltro(array $datos): unboundFrm010consultaarticulos
{
    return new unboundFrm010consultaarticulos($datos['ItemCode'] ?? null);
}

// Controlador
public function consultar(Request $request)
{
    $filtro = $this->repository->crearFiltro($request->query());
    return $this->repository->consultarArticulos($filtro);
}
```

### SQL y Mapeo en Repository

**SQL sencilla (JOIN simple, WHERE, ORDER BY):** Usar map con Query Builder:
```php
$resultados = DB::table('tabla')
    ->select('campo1', 'campo2')
    ->where('campo1', 'like', $filtro->campo1 . '%')
    ->get()
    ->map(function($item) {
        return new DbgModelo($item->campo1, $item->campo2);
    });
```

**SQL compleja (subconsultas, funciones agregadas):** Usar mapeo manual:
```php
$sql = "SELECT campo1, (SELECT MAX(campo) FROM otra WHERE ...) AS maximo FROM tabla WHERE ...";
$resultados = DB::select($sql, $parametros);

$lista = [];
foreach ($resultados as $item) {
    $lista[] = new DbgModelo($item->campo1, $item->maximo);
}
```

``` Codigo PHP/Laravel
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oitm extends Model
{
    protected $table = 'oitm';
    protected $primaryKey = 'ItemCode';
    public $incrementing = false;
    public $timestamps = false;  // Si no tiene created_at/updated_at

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

O si es un modelo para la grille:

``` Codigo PHP/Laravel
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DbgAlbaranesModelo extends Model
{
    protected $table = 'dbg_albaranes';
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

## Definición de Servicios

## Claves primarias compuestas

Para tablas con clave primaria compuesta (ej: `ITT1`, `CRD1`, `OITW`, `IGE1`), el modelo Eloquent no funciona correctamente con los métodos `save()` y `delete()` porque Laravel no maneja bien claves primarias que son arrays.

**IMPORTANTE**: 
- En el **modelo**: definir `protected $primaryKey = ['Code', 'LineId'];` y `public $incrementing = false;`
- En el **repositorio**: usar `DB::table()` directamente para update y delete (NO usar Eloquent save/delete)

``` Codigo PHP/Laravel
// Modelo con clave compuesta
class IGE1 extends Model
{
    protected $table = 'ige1';
    protected $primaryKey = ['Code', 'LineId'];
    public $incrementing = false;
    public $timestamps = false;
}
```

**Método update - USAR SIEMPRE DB::table():**
``` Codigo PHP/Laravel
public function update(IGE1 $elemento): array
{
    try {
        $actualizado = IGE1::where('Code', $elemento->Code)
            ->where('LineId', $elemento->LineId)
            ->update([
                'ItemCode' => $elemento->ItemCode,
                'Dscripcion' => $elemento->Dscripcion,
                'Quantity' => $elemento->Quantity,
                'WhsCode' => $elemento->WhsCode
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

**Método delete - USAR SIEMPRE DB::table():**
``` Codigo PHP/Laravel
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

**Controlador con parámetros de ruta:**
``` Codigo PHP/Laravel
// Rutas con parámetros
Route::get('/ige1/{code}/{lineId}', [IGE1Controller::class, 'getByKey']);
Route::put('/ige1/{code}/{lineId}', [IGE1Controller::class, 'update']);
Route::delete('/ige1/{code}/{lineId}', [IGE1Controller::class, 'delete']);

// Controller
public function getByKey(string $code, int $lineId)
{
    return $this->repository->getByKey($code, $lineId);
}

public function update(Request $request, string $code, int $lineId)
{
    $elemento = new IGE1();
    $elemento->Code = $code;
    $elemento->LineId = $lineId;
    $elemento->ItemCode = $request->input('ItemCode');
    // ...
    return $this->repository->update($elemento);
}

public function delete(string $code, int $lineId)
{
    return $this->repository->delete($code, $lineId);
}
```

**Errores comunes si no se sigue esta norma:**
- `Illegal offset type` - al usar `save()` en modelo con clave compuesta
- `null given` - al recibir parámetros de ruta incorrectamente en el controller
- `Foreign key constraint failed` - al ejecutar tests sin crear datos relacionados

En el pseudocódigo podemos indicar una serie de servicios que podemos utilizar, vamos a crear una interfaz con una serie de funciones que devuelven
tipo array.

El nombre de la interface será  I[Nombre]Repository

**Método Patch**: Usa Illuminate\Http\Request para recibir los campos a actualizar de forma opcional.

**Todos los métodos devuelven un array con la estructura:**
```php
return [
    'success' => true|false,
    'data' => $modelo|null,
    'message' => 'Texto descriptivo'
];
```

Vamos a poner un ejemplo:

- Add: Entrada OitmModelo, salida OitmModelo

Esto se traduciría con:

``` Codigo PHP/Laravel
<?php

namespace App\Interfaces;

use App\Models\OITMModelo;

interface IOITMRepository
{
    /**
     * Añade un objeto OITMModelo
     *
     * @param OITMModelo $elemento
     * @return array con los datos del artículo
     */
    public function add(OITMModelo $elemento): array;
}
```

Podemos tener funciones asociadas a un procedimiento almacenado:

- DameStock: Entrada itemcode, Salida Decimal, Devuelve el stock de un articulo

- Patch: Entrada itemCode + Request, Salida Modelo

``` Codigo PHP/Laravel
<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface IOitmRepository
{
    /**
     * Actualiza parcialmente un artículo.
     *
     * @param Request $request datos con ItemName y/o OnHand
     * @param string $itemCode
     * @return array
     */
    public function patch(Request $request, string $itemCode): array;
}
```

``` Codigo PHP/Laravel
<?php

namespace App\Repositories;

use App\Interfaces\IOitmRepository;
use App\Models\Oitm;
use Illuminate\Http\Request;

class OitmRepository implements IOitmRepository
{
    public function patch(Request $request, string $itemCode): array
    {
        $elemento = Oitm::find($itemCode);
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
        return ['success' => true, 'data' => $elemento, 'message' => 'Actualizado'];
    }
}
```

- En el análisis se indicarán los servicios necesarios, no es necesario añadir más.
- Siempre generaremos un docblock con todo lo indicado en la especificación de pseudocódigo y luego aparecerá la descripción
de los parámetros.

Tambien generaremos la clase Repository que implementa la interfaz:

``` Codigo PHP/Laravel
<?php

namespace App\Repositories;

use App\Interfaces\IOitmRepository;
use App\Models\OitmModelo;
use Illuminate\Support\Facades\DB;

class OitmRepository implements IOitmRepository
{
    /**
     * Añade un objeto OitmModelo
     *
     * @param OitmModelo $elemento
     * @return array
     */
    public function add(OitmModelo $elemento): array
    {
        try {
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Elemento guardado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ];
        }
    }
}
```

## Registro de dependencias en AppServiceProvider

Después de crear la interfaz y el repositorio, registrar el binding en `app/Providers/AppServiceProvider.php`:

- Para **tablas de BD**: usar `App\Interfaces\`
- Para **pantallas**: usar `App\InterfacesForm\`

```php
// En el método register()
use App\InterfacesForm\IFrm012fichaArticuloRepository;
use App\Repositories\Frm012fichaArticuloRepository;

$this->app->bind(IFrm012fichaArticuloRepository::class, Frm012fichaArticuloRepository::class);
```

## Import en routes/api.php

Añadir el import del controlador:

```php
use App\Http\Controllers\Frm012Controller;
```

## Testing con PHPUnit

### Tests de API REST

Crear archivos de test en `tests/Feature/` siguiendo el patrón `<Tabla>ApiTest.php`:

``` Codigo PHP/Laravel
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
                    'Code' => 'LIST001'
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
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('oitt', ['Code' => 'LIST002']);
    }
}
```

### Ejecución de tests

```bash
php artisan test              # Todos los tests
php artisan test --filter=OITTApiTest  # Solo tests de OITT
```

### Normas para tests

- Usar `RefreshDatabase` para cada test
- Crear datos con el modelo antes de cada test
- Verificar con `assertJson` y `assertDatabaseHas`/`assertDatabaseMissing`
- Verificar mensajes de respuesta con mayúsculas/minúsculas exactas
- Los tests deben incluir todos los campos obligatorios del modelo (ej: `CardType` en `OCRD`)
```