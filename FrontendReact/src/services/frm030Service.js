import { API_URL } from '../config/api.js';

export class frm030Service {
    static async buscar(CardCode) {
        const response = await fetch(`${API_URL}/frm030fichacliente?cardCode=${encodeURIComponent(CardCode)}`);
        return response.json();
    }
}