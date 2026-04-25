# OITM - Tabla de artículos

## Prompt de origen
> Crear la tabla OITM maestro de artículos con los campos ItemCode y ItemName.

## Modelo de datos

Oitm: Objeto
- ItemCode: String(50) - Código de artículo (PK)
- ItemName: String(200) - Nombre del artículo
- OnHand: Decimal - Cantidad en stock

## Servicios

- GetByKey: Entrada ItemCode, Salida Oitm
- Add: Entrada Oitm, Salida Oitm
- Update: Entrada Oitm, Salida Oitm
- Delete: Entrada ItemCode, Salida Boolean
- Patch: Entrada ItemCode, OnHand, Salida Oitm