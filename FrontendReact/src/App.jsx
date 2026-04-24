import { BrowserRouter, Routes, Route, Link, useSearchParams, Navigate } from 'react-router-dom';
import { Layout, Menu } from 'antd';
import { useState, useEffect } from 'react';
import Frm010ConsultaArticulos from './pages/Frm010ConsultaArticulos';
import Frm020ConsultaClientes from './pages/Frm020ConsultaClientes';
import Frm012 from './pages/Frm012';
import Frm030 from './pages/Frm030';

const { Header, Content } = Layout;

function App() {
    const [frm010Data, setFrm010Data] = useState([]);
    const [frm010ItemCode, setFrm010ItemCode] = useState('');
    const [frm020Data, setFrm020Data] = useState([]);
    const [frm020CardCode, setFrm020CardCode] = useState('');

    return (
        <BrowserRouter>
            <Layout style={{ minHeight: '100vh' }}>
                <Header style={{ display: 'flex', alignItems: 'center' }}>
                    <Menu
                        mode="horizontal"
                        defaultSelectedKeys={['/frm010']}
                        items={[
                            { key: '/frm010', label: <Link to="/frm010">Consulta Artículos</Link> },
                            { key: '/frm020', label: <Link to="/frm020">Consulta Clientes</Link> }
                        ]}
                        style={{ flex: 1, minWidth: 0 }}
                    />
                </Header>
                <Content style={{ padding: '24px' }}>
                    <Routes>
                        <Route path="/" element={<Navigate to="/frm010" replace />} />
                        <Route path="/frm010" element={
                            <Frm010ConsultaArticulos 
                                initialData={frm010Data} 
                                initialItemCode={frm010ItemCode}
                                onDataChange={setFrm010Data}
                                onItemCodeChange={setFrm010ItemCode}
                            />
                        } />
                        <Route path="/frm020" element={
                            <Frm020ConsultaClientes 
                                initialData={frm020Data} 
                                initialCardCode={frm020CardCode}
                                onDataChange={setFrm020Data}
                                onCardCodeChange={setFrm020CardCode}
                            />
                        } />
                        <Route path="/frm012" element={<Frm012Route />} />
                        <Route path="/frm030" element={<Frm030Route />} />
                    </Routes>
                </Content>
            </Layout>
        </BrowserRouter>
    );
}

function Frm012Route() {
    const [searchParams] = useSearchParams();
    const code = searchParams.get('code');
    return <Frm012 code={code} />;
}

function Frm030Route() {
    const [searchParams] = useSearchParams();
    const code = searchParams.get('code');
    return <Frm030 code={code} />;
}

export default App;