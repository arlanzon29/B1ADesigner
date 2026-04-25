---
name: crear-analisis
description: Skill que permite crear especificaciones de pantallas en formato pseudocódigo para generar pantallas PHP/Laravel, y especificaciones de tablas de base de datos.
---

# Guía para crear pseudocódigo de pantallas PHP/Laravel

Esta guía explica cómo escribir el **pseudocódigo necesario para generar una pantalla PHP/Laravel** sin necesidad de conocer programación web.

El pseudocódigo describe:

1. **Controles de la pantalla**
2. **Listas de datos (grids)**
3. **Datos que usa la pantalla**
4. **Servicios necesarios (interfaces y repositorios)**

La idea es **describir la pantalla como si fuese un formulario en papel**.

---

> **Ver ejemplos reales** en la carpeta `examples/`:
> - `001-OITM-tabla-articulos.md` - Ejemplo de tabla de base de datos
> - `010-consulta-articulos.md` - Ejemplo de pantalla de consulta

---

# 1. Cómo diseñar la pantalla

Primero piensa la pantalla como un formulario dividido en bloques:

Normalmente una pantalla tiene:

```
[Filtros o datos de búsqueda]

[Botón buscar]

[Lista de resultados]
```

Por ejemplo:

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

Eso se traduce directamente a pseudocódigo.

---

# 2. Crear un bloque de controles

Un bloque de controles empieza siempre con:

```
{div:Titulo,data:Modelo}
```

Ejemplo:

```
{div:Controles de edicion,data:unboundFrm010}
```

Esto significa:

* Título del bloque → "Controles de edición"
* Datos asociados → unboundFrm010

---

# 3. Escribir las filas de controles

Cada línea representa **una fila de la tabla**.

Ejemplo:

```
Cliente | {txt:Cliente} | {txt:RazonSocial}
```

Esto significa:

| Cliente | [textbox] | [textbox] |

Otro ejemplo:

```
Articulo | {txt:Articulo} | {txt:Descripcion}
```

---

# 4. Tipos de controles

Solo necesitas conocer **unos pocos tipos de controles**.

| Pseudocódigo             | Qué representa   |
| ------------------------ | ---------------- |
| {txt:Campo}              | Caja de texto    |
| {btn:Nombre}             | Botón            |
| {grid:Nombre,data:Lista} | Tabla de datos   |
| {col:Campo}              | Columna del grid |

---

# 5. Crear botones

Los botones se escriben así:

```
{btn:Buscar}
```

Ejemplo completo:

```
{btn:Buscar}
```

---

# 6. Crear un grid (tabla de resultados)

Los grids se usan para mostrar listas de datos.

Empiezan con:

```
{grid:Titulo,data:Lista}
```

Ejemplo:

```
{grid:Datos Albaranes,data:dbgAlbaranesFrm010consultaarticulos}
```

Luego se ponen dos líneas:

1️⃣ Títulos de columnas

```
Cliente | Razón Social | Articulo | Descripcion | Fecha | Cantidad
```

2️⃣ Campos

```
{col:Cliente} | {col:RazonSocial} | {col:Articulo} | {col:Descripcion} | {col:Fecha} | {col:Cantidad}
```

---

# 7. Ejemplo completo de pantalla

## Prompt de origen
> Crear una pantalla de consulta de albaranes filtrando por cliente y fecha.

## Tipo de pantalla

**CONSULTA** → Pantalla de lista/Buscar (usa GET con filtros)

## Diseño de pantalla

{div:Controles de edicion,data:unboundFrm010}

Cliente | {txt:Cliente} | {txt:RazonSocial}
Articulo | {txt:Articulo} | {txt:Descripcion}
A Fecha | {txt:Fecha} | Tipo | {txt:Tipo}

{btn:Buscar}

{grid:Datos Albaranes,data:dbgAlbaranesFrm010}

Cliente | Razón Social | Articulo | Descripcion | Fecha | Cantidad
{col:Cliente} | {col:RazonSocial} | {col:Articulo} | {col:Descripcion} | {col:Fecha} | {col:Cantidad}
```

---

# 8. Cómo definir los datos (Modelo)

Después del diseño de pantalla hay que indicar **qué datos usa la pantalla**.

Ejemplo:

```
unboundFrm010: Objeto
- Cliente: String
- RazonSocial: String
- Articulo: String
- Descripcion: String
- Fecha: DateTime
- Tipo: String (S-Si;N-No)
```

Esto representa los datos que el usuario introduce.

---

Acerca del nombre de los modelos indicar las pantalla tienen un numero que identifica la pantalla por ejemplo Frm010consultaarticulos, este 010 va a determinar el nombre del modelo.

Los archivos de especificaciones de pantallas tienen el formato:
```
FrmXXXNombreCompleto.md
```

Por ejemplo:
- `Frm010consultaarticulos.md`
- `Frm012fichaarticulo.md`

Los campos de pantalla típicamente van en un modelo llamado `unboundFrmXXX`, por ejemplo `unboundFrm010`

Los datos de los grids van en un modelo que empieza por `dbg<Nombre>FrmXXX`, por ejemplo `dbgAlbaranesFrm010`

# 9. Cómo definir listas (grids)

Para cada grid hay que definir su estructura.

Ejemplo:

```
dbgAlbaranesFrm010: Objeto lista
- Cliente: String
- RazonSocial: String
- Articulo: String
- Descripcion: String
- Fecha: DateTime
- Cantidad: Decimal
```

---

# 10. Cómo definir servicios

Si la pantalla necesita lógica de negocio se indican los servicios.

Ejemplo:

```
Servicios

BuscarAlbaranes
Entrada: unboundFrm010
Salida: Lista dbgAlbaranesFrm010
```

Los servicios se generan como Interfaces y Repositorios en Laravel.
Puedes indicar una consulta SQL basada en las TABLAS (OITM,OCRD,OINV,OINV...), es algo opcional si esta claro.

- BuscarAlbaranes Entrada `unboundFrm010` salida `dbgAlbaranesFrm010`
   - SQL:
   ``` sql
   SELECT
      ODLN.CardCode Cliente,
      OCRD.CardName RazonSocial,
      ODLN.ItemCode Articulo,
      OITM.DsName Descripcion,
      ODLN.DocDate Fecha,
      ODLN.Quantity Cantidad
   FROM ODLN
   INNER JOIN OCRD ON ODLN.CardCode = OCRD.CardCode
   INNER JOIN OITM ON ODLN.ItemCode = OITM.ItemCode
   WHERE ODLN.CardCode = @Cliente OR @Cliente IS NULL
   ```

---

# 11. Reglas importantes

Para evitar errores:

✔ Los nombres de campos deben coincidir en todos los sitios
✔ Cada grid debe tener su lista de datos
✔ Cada bloque debe indicar su modelo de datos
✔ No usar espacios en los nombres de campos
✔ **SIEMPRE** incluir la sección `## Prompt de origen` con el texto exacto que originó la pantalla.

Ejemplo correcto:

```
RazonSocial
```

Ejemplo incorrecto:

```
Razon Social
```

---

# 13. Cómo crear especificaciones de tablas de base de datos

Las especificaciones de tablas definen la estructura de tablas en la base de datos (no son pantallas).

## Formato

```
# OWHS - tabla de Almacenes

## Modelo de datos

OWHS: Objeto
- WhsCode: String, código del almacén
- WhsName: String, descripción del almacén

## Servicios
- Get: Entrada(WhsCode) -> Salida(OWHS)
- Add: Entrada(OWHS) -> Salida(OWHS)
- Update: Entrada(OWHS) -> Salida(OWHS)
- Delete: Entrada(WhsCode) -> Salida(Boolean)
```

## Reglas

- El título debe ser `#` seguido del nombre de la tabla y una descripción
- **## Modelo de datos**: define los campos del objeto con formato `Campo: Tipo, descripción`
- **## Servicios**: lista de servicios en una sola línea con guiones al principio
- Formato de servicio: `- Nombre: Entrada(Tipo) -> Salida(Tipo)`
- Los servicios siempre son: Get, Add, Update, Delete

## Ejemplo completo

### Prompt de origen
> Crear una tabla OWHS de maestro de almacenes con dos campos: WhsCode (código) y WhsName (descripción).

### Resultado

```
# OWHS - tabla de Almacenes

## Modelo de datos

OWHS: Objeto
- WhsCode: String, código del almacén
- WhsName: String, descripción del almacén

## Servicios
- Get: Entrada(WhsCode) -> Salida(OWHS)
- Add: Entrada(OWHS) -> Salida(OWHS)
- Update: Entrada(OWHS) -> Salida(OWHS)
- Delete: Entrada(WhsCode) -> Salida(Boolean)
```

---

# 12. Forma recomendada de crear una pantalla

Siempre seguir este orden:

1️⃣ Indicar el `## Prompt de origen`
2️⃣ Dibujar la pantalla en papel (Pseudocódigo)
3️⃣ Escribir el bloque de controles
4️⃣ Añadir botones
5️⃣ Añadir grids
6️⃣ Definir los modelos de datos
7️⃣ Definir servicios



