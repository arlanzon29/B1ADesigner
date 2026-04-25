# OIGE - tabla de Transacción de entrada

## Modelo de datos

OIGE: Objeto
- Code: String, código de la transacción (PK)
- DocDate: Date, fecha de creación

## Servicios
- Get: Entrada(Code) -> Salida(OIGE)
- Add: Entrada(OIGE) -> Salida(OIGE)
- Update: Entrada(OIGE) -> Salida(OIGE)
- Delete: Entrada(Code) -> Salida(Boolean)