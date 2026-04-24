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