---
name: componente-react
description: Sirve para crear componentes React siguiendo un pseudocódigo
---

# Normas para la creación de componentes React

- El objetivo es transformar una especificación MD a componentes React con Ant Design
- Usar **react-router-dom** para routing
- Para cada pantalla se deben crear:
    1. **Service** en `src/services/`
    2. **Componente** en `src/pages/`

## Archivos a crear

```
src/
├── config/
│   └── api.js                    # API_URL global
├── services/
│   └── frmXXXCompletoService.js  # Servicio (nombre completo)
└── pages/
    └── FrmXXXCompleto.jsx       # Componente (PascalCase)
```

## Routing con react-router-dom

En App.jsx:

```javascript
import { BrowserRouter, Routes, Route, Link, useSearchParams, Navigate } from 'react-router-dom';
import Frm010consultaArticulos from './pages/Frm010consultaArticulos';
import Frm012fichaArticulo from './pages/Frm012fichaArticulo';

function App() {
    return (
        <BrowserRouter>
            <Layout>
                <Menu items={[
                    { key: '/frm010consultaarticulos', label: <Link to="/frm010consultaarticulos">Consulta</Link> }
                ]} />
                <Content>
                    <Routes>
                        <Route path="/" element={<Navigate to="/frm010consultaarticulos" replace />} />
                        <Route path="/frm010consultaarticulos" element={<Frm010consultaArticulos />} />
                        <Route path="/frm012fichaarticulo" element={<Frm012fichaArticuloRoute />} />
                    </Routes>
                </Content>
            </Layout>
        </BrowserRouter>
    );
}

function Frm012fichaArticuloRoute() {
    const [searchParams] = useSearchParams();
    const code = searchParams.get('code');
    return <Frm012fichaArticulo code={code} />;
}
```

## Estructura de Servicio

```javascript
import { API_URL } from '../config/api.js';

export class frm012ConsultaArticulosService {  // ⚠️ El nombre de la clase debe ser igual al archivo sin "Service"
    static async buscar(ItemCode) {
        const response = await fetch(`${API_URL}/frm012fichaarticulo/${encodeURIComponent(ItemCode)}`);
        return response.json();
    }
}
```

## Componente con props para persistencia

Si el componente necesita mantener datos al navegar, receber props desde App:

```javascript
import { useNavigate } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { Input, Button, Table, message } from 'antd';
import { frm010consultaArticulosService } from '../services/frm010consultaArticulosService';

export default function Frm010consultaArticulos({ initialData = [], initialItemCode = '', onDataChange, onItemCodeChange }) {
    const navigate = useNavigate();
    const [itemCode, setItemCode] = useState(initialItemCode);
    const [data, setData] = useState(initialData);

    useEffect(() => {
        setItemCode(initialItemCode);
        setData(initialData);
    }, [initialItemCode, initialData]);

    useEffect(() => {
        onDataChange?.(data);
        onItemCodeChange?.(itemCode);
    }, [data, itemCode]);

    const abrirDetalle = (code) => {
        navigate('/frm012fichaarticulo?code=' + code);
    };

    return (
        <>
            <Input value={itemCode} onChange={(e) => setItemCode(e.target.value)} />
            <Table dataSource={data} rowKey="ItemCode" />
        </>
    );
}
```

## Estado global en App

Para mantener datos al navegar entre pantallas, usar estado en App y pasar como props:

```javascript
function App() {
    const [frm010consultaArticulosData, setFrm010consultaArticulosData] = useState([]);
    const [frm010consultaArticulosItemCode, setFrm010consultaArticulosItemCode] = useState('');
    const [frm020consultaClientesData, setFrm020consultaClientesData] = useState([]);
    const [frm020consultaClientesCardCode, setFrm020consultaClientesCardCode] = useState('');

    return (
        <Routes>
            <Route path="/frm010consultaarticulos" element={
                <Frm010consultaArticulos 
                    initialData={frm010consultaArticulosData} 
                    initialItemCode={frm010consultaArticulosItemCode}
                    onDataChange={setFrm010consultaArticulosData}
                    onItemCodeChange={setFrm010consultaArticulosItemCode}
                />
            } />
            <Route path="/frm020consultaclientes" element={
                <Frm020consultaClientes 
                    initialData={frm020consultaClientesData} 
                    initialCardCode={frm020consultaClientesCardCode}
                    onDataChange={setFrm020consultaClientesData}
                    onCardCodeChange={setFrm020consultaClientesCardCode}
                />
            } />
        </Routes>
    );
}
```

## Nomenclatura

- **Archivos**: `frmXXXCompletoService.js`, `FrmXXXCompleto.jsx`
- **Clase servicio**: `frmXXXCompletoService` (debe coincidir con el nombre del archivo)
- **Export default**: igual al nombre del componente
- **Parámetro props**: `code` para fichas

## Errores comunes

1. **"does not provide an export named"** → Verificar que el nombre de la clase coincida con el import
2. **"is not instantiable"** (Laravel) → Registrar binding en AppServiceProvider
3. **Component remount** → Usar estado en App y pasar como props

## Response API

```json
{
    "success": true,
    "data": [...],
    "message": "Texto"
}
```