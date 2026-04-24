import { useNavigate } from 'react-router-dom';
import { useState, useEffect } from 'react';
import { Input, Button, Table, message } from 'antd';
import { frm010Service } from '../services/frm010Service';

export default function Frm010ConsultaArticulos({ initialData = [], initialItemCode = '', onDataChange, onItemCodeChange }) {
    const navigate = useNavigate();
    const [itemCode, setItemCode] = useState(initialItemCode);
    const [data, setData] = useState(initialData);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        setItemCode(initialItemCode);
        setData(initialData);
    }, [initialItemCode, initialData]);

    useEffect(() => {
        onDataChange?.(data);
        onItemCodeChange?.(itemCode);
    }, [data, itemCode]);

    const handleConsultar = async () => {
        if (!itemCode.trim()) {
            message.error('Introduce un código');
            return;
        }

        setLoading(true);
        try {
            const response = await frm010Service.consultar(itemCode);
            if (response.success) {
                const articulos = Array.isArray(response.data) ? response.data : [response.data];
                setData(articulos.filter(a => a !== null));
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
        { title: 'Código', dataIndex: 'ItemCode', key: 'ItemCode' },
        { title: 'Descripción', dataIndex: 'ItemName', key: 'ItemName' },
        { title: 'Stock', dataIndex: 'OnHand', key: 'OnHand' },
        {
            title: 'Acción',
            key: 'action',
            render: (_, record) => (
                <Button onClick={() => navigate('/frm012?code=' + record.ItemCode)}>
                    Ficha
                </Button>
            )
        }
    ];

    return (
        <>
            <div style={{ marginBottom: 16 }}>
                <Input
                    placeholder="Código del artículo"
                    value={itemCode}
                    onChange={(e) => setItemCode(e.target.value)}
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
                rowKey="ItemCode"
                pagination={false}
            />
        </>
    );
}