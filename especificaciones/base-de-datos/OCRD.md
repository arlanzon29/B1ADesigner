# OCDR - Tabla de interlocutores comerciales

## Prompt de origen
> Crear la tabla OCRD tabla de interlocutores comerciales con los campos CardCode, CardName y CardType.

## Modelo de datos

OCRD: Objeto
- CardCode: String(50) - Código de interlocutor (PK)
- CardName: String(200) - Nombre del interlocutor
- CardType: String(1) - Tipo (C-Cliente, S-Proveedor)

## Servicios

- GetByKey: Entrada CardCode, Salida OCRD
- Add: Entrada OCRD, Salida OCRD
- Update: Entrada OCRD, Salida OCRD
- Delete: Entrada CardCode, Salida Boolean
- Patch: Entrada CardCode + Request, Salida OCRD