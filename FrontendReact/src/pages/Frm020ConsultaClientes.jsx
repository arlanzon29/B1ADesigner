import { useNavigate } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { Input, Button, Table, message } from 'antd';
import { frm020Service } from '../services/frm020Service';

export default function Frm020ConsultaClientes({ initialData = [], initialCardCode = '', onDataChange, onCardCodeChange }) {
    const navigate = useNavigate();
    const [cardCode, setCardCode] = useState(initialCardCode);
    const [data, setData] = useState(initialData);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        setCardCode(initialCardCode);
        setData(initialData);
    }, [initialCardCode, initialData]);

    useEffect(() => {
        onDataChange?.(data);
        onCardCodeChange?.(cardCode);
    }, [data, cardCode]);

    const handleConsultar = async () => {
        if (!cardCode.trim()) {
            message.error('Introduce un código');
            return;
        }

        setLoading(true);
        try {
            const response = await frm020Service.consultar(cardCode);
            if (response.success) {
                const clientes = Array.isArray(response.data) ? response.data : [response.data];
                setData(clientes.filter(c => c !== null));
            } else {
                message.error(response.message);
                setData([]);
            }
        } catch (error) {
            message.error('Error: ' + error.message);
        } finally {
            setLoading(false);
        }
    };

    const columns = [
        { title: 'Código', dataIndex: 'CardCode', key: 'CardCode' },
        { title: 'Nombre', dataIndex: 'CardName', key: 'CardName' },
        { title: 'Tipo', dataIndex: 'CardType', key: 'CardType', render: (type) => type === 'C' ? 'Cliente' : type === 'S' ? 'Proveedor' : type },
        {
            title: 'Acción',
            key: 'action',
            render: (_, record) => (
                <Button onClick={() => navigate('/frm030?code=' + record.CardCode)}>
                    Ficha
                </Button>
            )
        }
    ];

    return (
        <>
            <div style={{ marginBottom: 16 }}>
                <Input
                    placeholder="Código del cliente"
                    value={cardCode}
                    onChange={(e) => setCardCode(e.target.value)}
                    style={{ width: 200, marginRight: 8 }}
                    onPressEnter={handleConsultar}
                />
                <Button type="primary" onClick={handleConsultar} loading={loading}>
                    Consultar
                </Button>
            </div>
            <Table
                columns={columns}
                dataSource={data}
                rowKey="CardCode"
                pagination={false}
            />
        </>
    );
}