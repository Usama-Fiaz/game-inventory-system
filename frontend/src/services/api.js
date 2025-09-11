import axios from 'axios';

const API_BASE_URL = process.env.REACT_APP_API_BASE_URL || 'http://127.0.0.1:8000';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

export const itemsApi = {
  getItems: async () => {
    const response = await api.get('/api/items');
    return response.data;
  },

  addItem: async (itemData) => {
    const response = await api.post('/api/items', itemData);
    return response.data;
  },

  updateItem: async (id, itemData) => {
    const response = await api.put(`/api/items/${id}`, itemData);
    return response.data;
  },

  deleteItem: async (id) => {
    const response = await api.delete(`/api/items/${id}`);
    return response.data;
  },
};

export default api;
