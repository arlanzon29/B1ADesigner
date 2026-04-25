# ITT1 - Tabla de detalle de lista de materiales

## Prompt de origen
> Crear la tabla ITT1 de detalle de lista de materiales con los campos Code (PK/FK a OITT), LineId (PK), ItemCode (artículo a consumir), ItemName (descripción del artículo a consumir) y Quantity (cantidad a consumir).

## Modelo de datos

Itt1: Objeto
- Code: String(50) - Código de la lista de materiales (PK, FK a OITT)
- LineId: Integer - Número de línea (PK)
- ItemCode: String(50) - Código del artículo a consumir
- ItemName: String(200) - Descripción del artículo a consumir
- Quantity: Decimal - Cantidad a consumir

## Servicios

- GetByKey: Entrada Code, LineId, Salida Itt1
- Add: Entrada Itt1, Salida Itt1
- Update: Entrada Itt1, Salida Itt1
- Delete: Entrada Code, LineId, Salida Boolean
- GetByCode: Entrada Code, Salida Lista Itt1