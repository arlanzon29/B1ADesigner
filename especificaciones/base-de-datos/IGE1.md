# IGE1 - tabla de Detalle de Transacción de entrada

## Modelo de datos

IGE1: Objeto
- Code: String, código de la transacción (PK, FK:OIGE)
- LineId: int, número de línea (PK)
- ItemCode: String, código de artículo (FK:OITM)
- Dscripcion: String(200), descripción del artículo
- Quantity: Decimal, cantidad
- WhsCode: String, código de almacén (FK:OWHS)

## Servicios
- Get: Entrada(Code,LineId) -> Salida(IGE1)
- GetByCode: Entrada(Code) -> Salida(Lista IGE1)
- Add: Entrada(IGE1) -> Salida(IGE1)
- Update: Entrada(IGE1) -> Salida(IGE1)
- Delete: Entrada(Code,LineId) -> Salida(Boolean)