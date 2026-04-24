import { API_URL } from '../config/api.js';

export class frm020Service {
    static async consultar(CardCode) {
        const response = await fetch(`${API_URL}/frm020consultaclientes`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ CardCode })
        });
        return response.json();
    }
}