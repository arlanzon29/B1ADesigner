# OSHP - tabla de Clase de Expedición

## Prompt de origen
> Crear una tabla OSHP de maestro de clase de expedición con dos campos: Code string(50) PK y Name string(200) descripción.

## Modelo de datos

OSHP: Objeto
- Code: String, código de la clase de expedición
- Name: String, descripción de la clase de expedición

## Servicios
- Get:    Entrada(Code) -> Salida(OSHP)
- Add:    Entrada(OSHP)    -> Salida(OSHP)
- Update: Entrada(OSHP)    -> Salida(OSHP)
- Delete: Entrada(Code) -> Salida(Boolean)