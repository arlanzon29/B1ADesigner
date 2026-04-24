# Frm020ConsultaClientes - Consulta de Clientes

## Prompt de origen
> Crear una pantalla de consulta de clientes con un campo de filtro y un botón de consultar. Mostrar un grid con código, razón social, tipo de interlocutor y un botón ficha.

## Diseño de pantalla

{div:Criterios de búsqueda,data:Frm020Unbound}
Código|{txt:CardCode}

{btn:Consultar}

{grid:Datos Clientes,data:Frm020DbgClientes}
Código|Razón Social|Tipo
{col:CardCode}|{col:CardName}|{col:CardType}|{btn:Ficha}

El boton de Ficha llevará a la pantalla Frm0030FichaCliente pasando por parametro el codigo del articulo

## Modelo de datos

Frm020Unbound: Objeto
- CardCode: String - Código de cliente

Frm020DbgClientes: Lista de objetos
- CardCode: String
- CardName: String
- CardType: String (C-Cliente, S-Proveedor)

## Servicios

- ConsultarClientes: Entrada Frm020Unbound, Salida Frm020DbgClientes
    - SQL:
    ```sql
    SELECT CardCode, CardName, CardType
    FROM ocrd
    WHERE CardCode like '%@CardCode' or CardName like '%CardName%'
    ```