## Prompt de origen

Crear una pantalla para consultar los datos de un cliente: Código, razón social y tipo.

Es una pantalla de ficha que recibe el codigo de articulo por parametro.


## Diseño de pantalla

{div:Resultado,data:frm030Unbound}

Código|{txt:CardCode}
Razón Social|{txt:CardName}
Tipo|{cbo:CardType:Cliente,Proveedor}

## Modelo de Datos

frm030Unbound: Objeto
- CardCode: String
- CardName: String
- CardType: String

## Servicios

BuscarCliente
Entrada: CardCode
Salida: frm030Unbound

- SQL:
```sql
SELECT
    CardCode,
    CardName,
    CardType
FROM OCRD
WHERE CardCode = @CardCode
```