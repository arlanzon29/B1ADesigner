import { API_URL } from '../config/api.js';

export class frm010Service {
    static async consultar(ItemCode) {
        const response = await fetch(`${API_URL}/frm010consultaarticulos`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ItemCode })
        });
        return response.json();
    }
}