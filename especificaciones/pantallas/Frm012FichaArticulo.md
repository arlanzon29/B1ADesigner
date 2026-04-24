## Prompt de origen

Crear una pantalla para consultar los datos de un determinado artículo: Código, descripción y stock.

Es una pantalla de ficha que recibe el codigo de articulo por parametro.


## Diseño de pantalla



{div:Resultado,data:frm012DbgArticulo,frm012Unbound}

Código|{col:ItemCode}
Descripción|{col:ItemName}
Stock|{col:OnHand}

## Modelo de Datos



frm012Unbound: Objeto lista
- ItemCode: String
- ItemName: String
- OnHand: Decimal

## Servicios

BuscarArticulo Entrada: ItemCode Salida: frm012Unbound

- SQL:
```sql
SELECT
    ItemCode,
    ItemName,
    OnHand
FROM OITM
WHERE ItemCode = @ItemCode
```