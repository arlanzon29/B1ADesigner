import { useState, useEffect } from 'react';
import { Table, Descriptions, message } from 'antd';
import { frm012Service } from '../services/frm012Service';

export default function Frm012({ code }) {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (code) {
            buscar(code);
        }
    }, [code]);

    const buscar = async (itemCode) => {
        setLoading(true);
        try {
            const response = await frm012Service.buscar(itemCode);
            if (response.success) {
                setData(response.data);
            } else {
                message.error(response.message);
                setData(null);
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
        { title: 'Stock', dataIndex: 'OnHand', key: 'OnHand' }
    ];

    if (!data) {
        return <message>Consultando artículo...</message>;
    }

    return (
        <Descriptions bordered column={1}>
            <Descriptions.Item label="Código">{data.ItemCode}</Descriptions.Item>
            <Descriptions.Item label="Descripción">{data.ItemName}</Descriptions.Item>
            <Descriptions.Item label="Stock">{data.OnHand}</Descriptions.Item>
        </Descriptions>
    );
}