import { useState, useEffect } from 'react';
import { Descriptions, Select, message } from 'antd';
import { frm030Service } from '../services/frm030Service';

const { Option } = Select;

export default function Frm030({ code }) {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (code) {
            buscar(code);
        }
    }, [code]);

    const buscar = async (cardCode) => {
        setLoading(true);
        try {
            const response = await frm030Service.buscar(cardCode);
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

    if (!data) {
        return <message>Consultando cliente...</message>;
    }

    return (
        <Descriptions bordered column={1}>
            <Descriptions.Item label="Código">{data.CardCode}</Descriptions.Item>
            <Descriptions.Item label="Razón Social">{data.CardName}</Descriptions.Item>
            <Descriptions.Item label="Tipo">
                <Select value={data.CardType} style={{ width: 200 }} disabled>
                    <Option value="C">Cliente</Option>
                    <Option value="S">Proveedor</Option>
                </Select>
            </Descriptions.Item>
        </Descriptions>
    );
}