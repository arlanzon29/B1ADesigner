import { API_URL } from '../config/api.js';

export class frm012Service {
    static async buscar(ItemCode) {
        const response = await fetch(`${API_URL}/frm012fichaarticulo?itemCode=${encodeURIComponent(ItemCode)}`);
        return response.json();
    }
}