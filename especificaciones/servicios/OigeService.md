# OigeService - Servicio de transacción de entrada

## Prompt de origen
> Crear un servicio que reciba una cabecera OIGE y una lista de líneas IGE1, cree la transacción de entrada y actualice el stock del artículo (OITM.OnHand) y el stock por almacén (OITW.OnHand).

## Modelo de datos

### OigeServiceRequest
- Cabecera: Objeto
  - Code: String, código de la transacción
  - DocDate: Date, fecha de creación
- Lineas: Lista de objetos
  - ItemCode: String, código de artículo
  - Dscripcion: String, descripción del artículo
  - Quantity: Decimal, cantidad
  - WhsCode: String, código de almacén

## Servicios

- Crear: Entrada(OigeServiceRequest) -> Salida(OIGE)
  - Descripción: Crea la cabecera OIGE, las líneas IGE1, y actualiza el stock
  - Reglas de negocio:
    1. Validar que el artículo (ItemCode) existe en OITM
    2. Validar que el almacén (WhsCode) existe en OWHS
    3. Crear la cabecera en OIGE
    4. Crear cada línea en IGE1 con LineId secuencial (1, 2...)
    5. Actualizar OITM.OnHand = OITM.OnHand + Quantity (por cada línea)
    6. Actualizar OITW.OnHand = OITW.OnHand + Quantity (crear registro si no existe)
    7. Usar transacción para garantizar atomicidad

## Notas

- Solo método CREAR (no UPDATE ni DELETE)
- El LineId es secuencial por transacción ( 1, 2...)
- Si falla cualquier paso, se revierte toda la transacción