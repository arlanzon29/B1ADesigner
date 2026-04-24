# CRD1 - Direcciones de Clientes

Tabla de detalle de OCRD (maestro de clientes)

## Prompt de origen
> Crear una nueva tabla CRD1 de Direcciones con los campos CardCode (PK, string), LineId (PK, int) y Address (string).

## Modelo de datos

CRD1: Objeto
- CardCode: String, código de cliente (PK)
- LineId: Integer, número de línea (PK)
- Address: String, dirección del cliente

## Servicios
- Get: Entrada(CardCode, LineId) -> Salida(CRD1)
- GetAll: Entrada(CardCode) -> Salida(Lista CRD1)
- Add: Entrada(CRD1) -> Salida(CRD1)
- Update: Entrada(CRD1) -> Salida(CRD1)
- Delete: Entrada(CardCode, LineId) -> Salida(Boolean)