import axios from 'axios';

// Change this to your actual API base URL
// For Expo Snack, you might need to use your actual IP address or deployed URL
const BASE_URL = 'http://localhost:8000/api/v1';

class ApiService {
  constructor() {
    this.api = axios.create({
      baseURL: BASE_URL,
      timeout: 10000,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    });

    // Request interceptor for auth token
    this.api.interceptors.request.use(
      (config) => {
        if (this.authToken) {
          config.headers.Authorization = `Bearer ${this.authToken}`;
        }
        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );

    // Response interceptor for error handling
    this.api.interceptors.response.use(
      (response) => response,
      (error) => {
        if (error.response?.status === 401) {
          // Handle unauthorized access
          this.authToken = null;
        }
        return Promise.reject(error);
      }
    );
  }

  setAuthToken(token) {
    this.authToken = token;
  }

  // Health check
  async healthCheck() {
    return this.api.get('/health');
  }

  // Generic HTTP methods
  async get(url, params = {}) {
    return this.api.get(url, { params });
  }

  async post(url, data = {}) {
    return this.api.post(url, data);
  }

  async put(url, data = {}) {
    return this.api.put(url, data);
  }

  async delete(url) {
    return this.api.delete(url);
  }

  // Auth endpoints
  async login(email, password) {
    return this.post('/login', { email, password });
  }

  async register(name, email, password, passwordConfirmation) {
    return this.post('/register', {
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
    });
  }

  async logout() {
    return this.post('/logout');
  }

  async getUser() {
    return this.get('/user');
  }

  // Vehicle types
  async getVehicleTypes() {
    return this.get('/demo/vehicle-types');
  }

  // Parking operations
  async getParkingTransactions() {
    return this.get('/parking');
  }

  async createParkingTransaction(data) {
    return this.post('/demo/parking', data);
  }

  async getParkingTransaction(id) {
    return this.get(`/parking/${id}`);
  }

  // Statistics
  async getStats() {
    return this.get('/stats');
  }

  async getDailyReport(date) {
    return this.get('/reports/daily', { date });
  }

  async getMonthlyReport(month, year) {
    return this.get('/reports/monthly', { month, year });
  }
}

export default new ApiService();
