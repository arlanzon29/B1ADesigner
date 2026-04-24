# OITW - Stock por Artículo y Almacén

Tabla de detalle de OITM (maestro de artículos)

## Prompt de origen
> Crear una tabla OITW de Stock por artículo y almacén con los campos ItemCode (PK, FK a OITM), WhsCode (PK, FK a OWHS) y OnHand (double).

## Modelo de datos

OITW: Objeto
- ItemCode: String, código de artículo (PK, FK -> OITM)
- WhsCode: String, código de almacén (PK, FK -> OWHS)
- OnHand: Double, cantidad en stock

## Relaciones
- OITM: Maestro de artículos (uno a muchos)
- OWHS: Maestro de almacenes (uno a muchos)

## Servicios
- Get: Entrada(ItemCode, WhsCode) -> Salida(OITW)
- GetAll: Entrada(ItemCode) -> Salida(Lista OITW)
- Add: Entrada(OITW) -> Salida(OITW)
- Update: Entrada(OITW) -> Salida(OITW)
- Delete: Entrada(ItemCode, WhsCode) -> Salida(Boolean)