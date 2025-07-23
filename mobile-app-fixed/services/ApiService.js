// services/ApiService.js - Updated version
import AsyncStorage from '@react-native-async-storage/async-storage';

const BASE_URL = 'http://localhost:8000/api/v1'; // Update dengan IP Anda

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
      const response = await fetch(url, requestOptions);
      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || `HTTP Error: ${response.status}`);
      }

      return data;
    } catch (error) {
      console.error('API Request Error:', error);
      throw error;
    }
  }

  // Auth methods
  async login(email, password) {
    const data = await this.makeRequest('/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
    
    if (data.success && data.data.token) {
      await this.setAuthToken(data.data.token);
    }
    
    return data;
  }

  async register(name, email, password, passwordConfirmation) {
    const data = await this.makeRequest('/register', {
      method: 'POST',
      body: JSON.stringify({
        name,
        email,
        password,
        password_confirmation: passwordConfirmation,
      }),
    });
    
    if (data.success && data.data.token) {
      await this.setAuthToken(data.data.token);
    }
    
    return data;
  }

  async logout() {
    try {
      await this.makeRequest('/logout', { method: 'POST' });
    } finally {
      await this.setAuthToken(null);
    }
  }

  async getUser() {
    return await this.makeRequest('/user');
  }

  // Vehicle Types
  async getVehicleTypes() {
    return await this.makeRequest('/demo/vehicle-types');
  }

  // Parking operations
  async getParkingHistory(page = 1, filters = {}) {
    const params = new URLSearchParams({
      page: page.toString(),
      limit: '20',
      ...filters,
    });
    
    return await this.makeRequest(`/parking?${params}`);
  }

  async createParking(transactionData) {
    return await this.makeRequest('/demo/parking', {
      method: 'POST',
      body: JSON.stringify(transactionData),
    });
  }

  async searchParking(searchTerm) {
    return await this.makeRequest(`/parking?license_plate=${encodeURIComponent(searchTerm)}`);
  }

  // Statistics
  async getStats() {
    return await this.makeRequest('/stats');
  }

  async healthCheck() {
    return await this.makeRequest('/health');
  }
}

export default new ApiService();
