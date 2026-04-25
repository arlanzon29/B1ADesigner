# OITT - Tabla de cabecera de lista de materiales

## Prompt de origen
> Crear la tabla OITT de cabecera de lista de materiales de artículos con los campos Code (PK), ItemCode (código de artículo), ItemName (descripción del artículo) y Quantity (cantidad base).

## Modelo de datos

Oitt: Objeto
- Code: String(50) - Código de la lista de materiales (PK)
- ItemCode: String(50) - Código del artículo
- ItemName: String(200) - Descripción del artículo
- Quantity: Decimal - Cantidad base de la lista de materiales

## Servicios

- GetByKey: Entrada Code, Salida Oitt
- Add: Entrada Oitt, Salida Oitt
- Update: Entrada Oitt, Salida Oitt
- Delete: Entrada Code, Salida Boolean
- GetByItemCode: Entrada ItemCode, Salida Lista Oitt