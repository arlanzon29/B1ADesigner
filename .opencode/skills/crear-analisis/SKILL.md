---
name: crear-analisis
description: Genera especificaciones técnicas en formato pseudocódigo para pantallas PHP/Laravel, tablas de base de datos y servicios de negocio. Úsalo siempre que el usuario pida crear una pantalla, formulario, consulta, ficha, tabla de BD, o servicio en un proyecto Laravel/PHP, aunque no lo llame explícitamente "pseudocódigo" o "especificación". También se activa si el usuario menciona grids, filtros, albaranes, artículos, almacenes u otras entidades de negocio típicas de ERP.
---

# Guía para crear especificaciones de pantallas PHP/Laravel

Esta guía explica cómo escribir el **pseudocódigo necesario para generar una pantalla PHP/Laravel** sin necesidad de conocer programación web.

El pseudocódigo describe:

1. **Controles de la pantalla**
2. **Listas de datos (grids)**
3. **Modelos de datos que usa la pantalla**
4. **Servicios necesarios (interfaces y repositorios)**

La idea es **describir la pantalla como si fuese un formulario en papel**.

> **Ver ejemplos reales** en la carpeta `examples/`:
> - `001-OITM-tabla-articulos.md` — Ejemplo de tabla de base de datos
> - `010-consulta-articulos.md` — Ejemplo de pantalla de consulta

---

## Tipos de especificaciones

Este skill cubre tres tipos de documentos:

| Tipo | Cuándo usarlo | Carpeta |
|---|---|---|
| **Pantalla** | Formularios, consultas, fichas | `especificaciones/pantallas/` |
| **Tabla de BD** | Maestros y estructuras de datos | `especificaciones/base-de-datos/` |
| **Servicio** | Lógica de negocio con varias tablas | `especificaciones/servicios/` |

---

## Tipos de datos válidos

Usar siempre estos tipos en los modelos:

| Tipo | Uso |
|---|---|
| `String` | Texto, códigos, descripciones |
| `Integer` | Números enteros |
| `Decimal` | Cantidades, importes |
| `Boolean` | Verdadero/Falso |
| `Date` | Solo fecha |
| `DateTime` | Fecha y hora |

---

## Nomenclatura de archivos y modelos

Los archivos de pantallas siguen el formato:
```
FrmXXXNombreCompleto.md
```
Ejemplos: `Frm010consultaarticulos.md`, `Frm012fichaarticulo.md`

El número `XXX` determina los nombres de los modelos:

| Modelo | Patrón | Ejemplo |
|---|---|---|
| Datos del formulario | `unboundFrmXXX` | `unboundFrm010` |
| Datos de un grid | `dbg<Nombre>FrmXXX` | `dbgAlbaranesFrm010` |

---

# PARTE 1 — Especificaciones de pantallas

## 1. Diseña la pantalla en papel primero

Antes de escribir pseudocódigo, dibuja la pantalla como un formulario:

```
--------------------------------
   BUSQUEDA DE ALBARANES
--------------------------------

Cliente      [_______] [_______]
Articulo     [_______] [_______]
Fecha        [_______] Tipo [__]

             [Buscar]

--------------------------------
      LISTA DE ALBARANES
--------------------------------
Cliente | Articulo | Fecha | Cantidad
```

Ese dibujo se traduce directamente a pseudocódigo.

---

## 2. Bloques de controles

Un bloque de controles empieza siempre con:

```
{div:Titulo,data:Modelo}
```

Ejemplo:

```
{div:Controles de edicion,data:unboundFrm010}
```

- **Titulo** → texto que aparece como cabecera del bloque
- **Modelo** → nombre del objeto de datos asociado

---

## 3. Filas de controles

Cada línea del bloque representa **una fila**. Las columnas se separan con `|`.

```
Cliente  | {txt:Cliente} | {txt:RazonSocial}
Articulo | {txt:Articulo} | {txt:Descripcion}
Fecha    | {txt:Fecha} | Tipo | {txt:Tipo}
```

Resultado visual:

| Etiqueta | Control | Control |
|---|---|---|
| Cliente | [textbox] | [textbox] |
| Articulo | [textbox] | [textbox] |
| Fecha | [textbox] | Tipo | [textbox] |

---

## 4. Tipos de controles

| Pseudocódigo | Qué representa |
|---|---|
| `{txt:Campo}` | Caja de texto |
| `{btn:Nombre}` | Botón |
| `{grid:Nombre,data:Lista}` | Tabla de datos |
| `{col:Campo}` | Columna dentro de un grid |

> ⚠️ **Regla**: los nombres de campos no pueden tener espacios. Usar `RazonSocial`, no `Razon Social`.

---

## 5. Botones

```
{btn:Buscar}
```

Los botones se colocan solos en su propia línea, entre el bloque de filtros y el grid.

---

## 6. Grids (tablas de resultados)

Un grid tiene tres partes:

**1. Declaración:**
```
{grid:Datos Albaranes,data:dbgAlbaranesFrm010}
```

**2. Títulos de columnas** (texto visible):
```
Cliente | Razón Social | Articulo | Descripcion | Fecha | Cantidad
```

**3. Campos** (nombres técnicos):
```
{col:Cliente} | {col:RazonSocial} | {col:Articulo} | {col:Descripcion} | {col:Fecha} | {col:Cantidad}
```

> Los títulos y los campos deben tener el **mismo número de columnas** en el mismo orden.

---

## 7. Ejemplo completo de pantalla

### Prompt de origen
> Crear una pantalla de consulta de albaranes filtrando por cliente y fecha.

### Tipo de pantalla
**CONSULTA** → Pantalla de búsqueda (usa GET con filtros)

### Diseño de pantalla

```
{div:Controles de edicion,data:unboundFrm010}

Cliente  | {txt:Cliente} | {txt:RazonSocial}
Articulo | {txt:Articulo} | {txt:Descripcion}
Fecha    | {txt:Fecha} | Tipo | {txt:Tipo}

{btn:Buscar}

{grid:Datos Albaranes,data:dbgAlbaranesFrm010}

Cliente | Razón Social | Articulo | Descripcion | Fecha | Cantidad
{col:Cliente} | {col:RazonSocial} | {col:Articulo} | {col:Descripcion} | {col:Fecha} | {col:Cantidad}
```

### Modelos de datos

```
unboundFrm010: Objeto
- Cliente:     String
- RazonSocial: String
- Articulo:    String
- Descripcion: String
- Fecha:       DateTime
- Tipo:        String (S-Si;N-No)

dbgAlbaranesFrm010: Objeto lista
- Cliente:     String
- RazonSocial: String
- Articulo:    String
- Descripcion: String
- Fecha:       DateTime
- Cantidad:    Decimal
```

### Servicios

```
BuscarAlbaranes
Entrada: unboundFrm010
Salida:  Lista dbgAlbaranesFrm010
```

Con SQL opcional:

```sql
SELECT
   ODLN.CardCode  Cliente,
   OCRD.CardName  RazonSocial,
   ODLN.ItemCode  Articulo,
   OITM.DsName    Descripcion,
   ODLN.DocDate   Fecha,
   ODLN.Quantity  Cantidad
FROM ODLN
INNER JOIN OCRD ON ODLN.CardCode = OCRD.CardCode
INNER JOIN OITM ON ODLN.ItemCode = OITM.ItemCode
WHERE ODLN.CardCode = @Cliente OR @Cliente IS NULL
```

---

## 8. Orden recomendado para crear una pantalla

Seguir siempre este orden:

1. Escribir `## Prompt de origen` con el texto exacto del usuario
2. Dibujar la pantalla en papel (boceto)
3. Escribir el bloque de controles `{div:...}`
4. Añadir botones `{btn:...}`
5. Añadir grids `{grid:...}`
6. Definir los modelos de datos
7. Definir los servicios (con SQL si aplica)

---

# PARTE 2 — Especificaciones de tablas de base de datos

## 9. Formato de tabla de BD

```
# OWHS - tabla de Almacenes

## Modelo de datos

OWHS: Objeto
- WhsCode: String, código del almacén
- WhsName: String, descripción del almacén

## Servicios
- Get:    Entrada(WhsCode) -> Salida(OWHS)
- Add:    Entrada(OWHS)    -> Salida(OWHS)
- Update: Entrada(OWHS)    -> Salida(OWHS)
- Delete: Entrada(WhsCode) -> Salida(Boolean)
```

### Reglas

- El título sigue el formato: `# NOMBRE_TABLA - descripción`
- Siempre incluir los cuatro servicios: `Get`, `Add`, `Update`, `Delete`
- Cada campo lleva: `NombreCampo: Tipo, descripción breve`

### Ejemplo completo

#### Prompt de origen
> Crear una tabla OWHS de maestro de almacenes con dos campos: WhsCode (código) y WhsName (descripción).

#### Resultado

```
# OWHS - tabla de Almacenes

## Modelo de datos

OWHS: Objeto
- WhsCode: String, código del almacén
- WhsName: String, descripción del almacén

## Servicios
- Get:    Entrada(WhsCode) -> Salida(OWHS)
- Add:    Entrada(OWHS)    -> Salida(OWHS)
- Update: Entrada(OWHS)    -> Salida(OWHS)
- Delete: Entrada(WhsCode) -> Salida(Boolean)
```

---

# PARTE 3 — Especificaciones de servicios

## 10. Formato de servicio

Usar cuando la lógica de negocio involucra varias tablas (ej: crear transacción + actualizar stock).

```
# Transacción de Entrada - Servicio

## Prompt de origen
> Crear un servicio que reciba una cabecera OIGE y líneas IGE1, cree la transacción y actualice el stock.

## Modelo de datos

### TransaccionEntradaRequest
- Cabecera: Objeto
  - Code:    String, código de la transacción
  - DocDate: Date, fecha de creación
- Lineas: Lista de objetos
  - ItemCode:   String, código de artículo
  - Descripcion: String, descripción del artículo
  - Quantity:   Decimal, cantidad
  - WhsCode:    String, código de almacén

## Servicios

- Crear: Entrada(TransaccionEntradaRequest) -> Salida(OIGE), Transacción: Sí
  - Descripción: Crea la cabecera OIGE, las líneas IGE1 y actualiza el stock
  - Reglas de negocio:
    1. Validar que el artículo (ItemCode) existe en OITM
    2. Validar que el almacén (WhsCode) existe en OWHS
    3. Crear la cabecera en OIGE
    4. Crear cada línea en IGE1 con LineId secuencial
    5. Actualizar OITM.OnHand y OITW.OnHand
    6. Si falla cualquier paso, revertir toda la transacción

## Notas
- Solo método CREAR (no UPDATE ni DELETE)
```

### Reglas

- El título sigue el formato: `# NombreServicio - Servicio`
- Indicar siempre si cada método usa transacción: `Transacción: Sí` o `Transacción: No`
- Usar transacción cuando hay operaciones en varias tablas que deben ser atómicas
- Las reglas de negocio se numeran en orden de ejecución

---

# Reglas generales

| ✅ Correcto | ❌ Incorrecto |
|---|---|
| `RazonSocial` | `Razon Social` |
| Nombres de campos iguales en todos los sitios | Nombres distintos en modelo y grid |
| Siempre incluir `## Prompt de origen` | Omitir el prompt de origen |
| Un modelo por grid | Grid sin modelo definido |
| Tipos de datos de la tabla de tipos válidos | Tipos inventados o ambiguos |


