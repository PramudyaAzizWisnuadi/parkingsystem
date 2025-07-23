// services/ApiService.js - Unified version with Web compatibility
import AsyncStorage from '@react-native-async-storage/async-storage';

const BASE_URL = 'http://YOUR_IP_ADDRESS:8000/api/v1'; // Ganti dengan IP Address Anda

class ApiService {
  constructor() {
    this.baseURL = BASE_URL;
    this.token = null;
  }

  async setAuthToken(token) {
    this.token = token;
    if (token) {
      await AsyncStorage.setItem('auth_token', token);
    } else {
      await AsyncStorage.removeItem('auth_token');
    }
  }

  async getAuthToken() {
    if (!this.token) {
      this.token = await AsyncStorage.getItem('auth_token');
    }
    return this.token;
  }

  async makeRequest(endpoint, options = {}) {
    const url = `${this.baseURL}${endpoint}`;
    const token = await this.getAuthToken();

    const defaultOptions = {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...(token && { 'Authorization': `Bearer ${token}` }),
      },
    };

    const requestOptions = {
      ...defaultOptions,
      ...options,
      headers: {
        ...defaultOptions.headers,
        ...options.headers,
      },
    };

    try {
      console.log(`Making request to: ${url}`, requestOptions);
      const response = await fetch(url, requestOptions);
      
      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || `HTTP ${response.status}`);
      }

      const data = await response.json();
      console.log(`Response from ${url}:`, data);
      return data;
    } catch (error) {
      console.error(`API Error for ${url}:`, error);
      throw error;
    }
  }

  // Authentication
  async login(email, password) {
    return this.makeRequest('/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
  }

  async register(name, email, password, password_confirmation) {
    return this.makeRequest('/register', {
      method: 'POST',
      body: JSON.stringify({ name, email, password, password_confirmation }),
    });
  }

  async logout() {
    const response = await this.makeRequest('/logout', { method: 'POST' });
    await this.setAuthToken(null);
    return response;
  }

  async getUserProfile() {
    return this.makeRequest('/user');
  }

  // Vehicle Types - Unified format untuk Web dan Mobile compatibility
  async getVehicleTypes() {
    return this.makeRequest('/vehicle-types');
  }

  async getDemoVehicleTypes() {
    return this.makeRequest('/demo/vehicle-types');
  }

  // Parking Operations - Unified format
  async getParkingHistory(page = 1, filters = {}) {
    const params = new URLSearchParams({
      page: page.toString(),
      per_page: '10',
      ...filters
    });
    return this.makeRequest(`/parking?${params}`);
  }

  async createParkingTransaction(data) {
    return this.makeRequest('/parking', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  async createDemoParkingTransaction(data) {
    return this.makeRequest('/demo/parking', {
      method: 'POST',
      body: JSON.stringify(data),
    });
  }

  async getParkingTransaction(id) {
    return this.makeRequest(`/parking/${id}`);
  }

  async updateParkingTransaction(id, data) {
    return this.makeRequest(`/parking/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data),
    });
  }

  async deleteParkingTransaction(id) {
    return this.makeRequest(`/parking/${id}`, { method: 'DELETE' });
  }

  // Statistics
  async getStatistics(period = 'today') {
    return this.makeRequest(`/stats?period=${period}`);
  }

  async getDailyReport() {
    return this.makeRequest('/reports/daily');
  }

  async getMonthlyReport() {
    return this.makeRequest('/reports/monthly');
  }

  // Health Check
  async checkHealth() {
    return this.makeRequest('/health');
  }

  // Sync functionality
  async syncData(lastSyncTime = null) {
    const body = lastSyncTime ? JSON.stringify({ last_sync_time: lastSyncTime }) : '{}';
    return this.makeRequest('/sync', {
      method: 'POST',
      body,
    });
  }

  async getSyncStatus() {
    return this.makeRequest('/sync/status');
  }

  // Helper method untuk format consistency
  formatVehicleTypeData(vehicleType) {
    return {
      id: vehicleType.id,
      name: vehicleType.name,
      // Support both flat_rate (web) and rate (mobile) fields
      rate: vehicleType.rate || vehicleType.flat_rate,
      flat_rate: vehicleType.flat_rate || vehicleType.rate,
      formatted_rate: vehicleType.formatted_rate,
      is_active: vehicleType.is_active,
    };
  }

  formatParkingTransactionData(transaction) {
    return {
      id: transaction.id,
      ticket_number: transaction.ticket_number,
      license_plate: transaction.license_plate,
      vehicle_type: {
        id: transaction.vehicle_type.id,
        name: transaction.vehicle_type.name,
        // Support both formats
        rate: transaction.vehicle_type.rate || transaction.vehicle_type.flat_rate,
        flat_rate: transaction.vehicle_type.flat_rate || transaction.vehicle_type.rate,
      },
      amount: transaction.amount,
      formatted_amount: transaction.formatted_amount,
      entry_time: transaction.entry_time,
      formatted_entry_time: transaction.formatted_entry_time,
      notes: transaction.notes,
      operator: transaction.operator,
    };
  }
}

export default new ApiService();
