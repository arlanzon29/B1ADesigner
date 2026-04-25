# Frm010ConsultaArticulos - Consulta de Artículos

## Prompt de origen
> Crear una pantalla de consulta de artículos con un campo de búsqueda y un botón de consultar. Mostrar un grid con código, descripción y stock.

## Diseño de pantalla

{div:Criterios de búsqueda,data:Frm010Unbound}
Código|{txt:ItemCode}

{btn:Consultar}

{grid:Datos Artículos,data:Frm010DbgArticulos}
Código|Descripción|Stock
{col:ItemCode}|{col:ItemName}|{col:OnHand}|{btn:Ficha}

El botón de Ficha llevará a la pantalla Frm012fichaArticulo pasando por parámetro el código del artículo.

## Modelo de datos

Frm010Unbound: Objeto
- ItemCode: String - Código de artículo

Frm010DbgArticulos: Lista de objetos
- ItemCode: String
- ItemName: String
- OnHand: Decimal

## Servicios

- ConsultarArticulos: Entrada Frm010Unbound, Salida Frm010DbgArticulos
    - SQL:
    ```sql
    SELECT ItemCode, ItemName, OnHand
    FROM oitm
    WHERE ItemCode LIKE CONCAT(@ItemCode, '%')
    ```