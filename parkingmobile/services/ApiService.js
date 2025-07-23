class ApiService {
  constructor() {
    this.baseURL = 'http://192.168.1.100:8000/api/v1'; // Ganti dengan IP server Laravel Anda
    this.token = null;
  }

  // Set auth token
  setToken(token) {
    this.token = token;
  }

  // Get headers with auth token
  getHeaders() {
    const headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (this.token) {
      headers['Authorization'] = `Bearer ${this.token}`;
    }

    return headers;
  }

  // Login
  async login(email, password) {
    try {
      const response = await fetch(`${this.baseURL}/auth/login`, {
        method: 'POST',
        headers: this.getHeaders(),
        body: JSON.stringify({ email, password }),
      });

      const data = await response.json();
      
      if (data.success && data.token) {
        this.setToken(data.token);
      }

      return data;
    } catch (error) {
      throw new Error(`Login failed: ${error.message}`);
    }
  }

  // Logout
  async logout() {
    try {
      const response = await fetch(`${this.baseURL}/auth/logout`, {
        method: 'POST',
        headers: this.getHeaders(),
      });

      const data = await response.json();
      
      if (data.success) {
        this.token = null;
      }

      return data;
    } catch (error) {
      throw new Error(`Logout failed: ${error.message}`);
    }
  }

  // Get vehicle types
  async getVehicleTypes() {
    try {
      const response = await fetch(`${this.baseURL}/vehicle-types`, {
        method: 'GET',
        headers: this.getHeaders(),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to get vehicle types: ${error.message}`);
    }
  }

  // Get demo vehicle types (tanpa auth)
  async getDemoVehicleTypes() {
    try {
      const response = await fetch(`${this.baseURL}/vehicle-types/demo`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to get demo vehicle types: ${error.message}`);
    }
  }

  // Create parking transaction
  async createTransaction(transactionData) {
    try {
      const response = await fetch(`${this.baseURL}/parking`, {
        method: 'POST',
        headers: this.getHeaders(),
        body: JSON.stringify(transactionData),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to create transaction: ${error.message}`);
    }
  }

  // Create demo transaction (tanpa auth)
  async createDemoTransaction(transactionData) {
    try {
      const response = await fetch(`${this.baseURL}/parking/demo`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify(transactionData),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to create demo transaction: ${error.message}`);
    }
  }

  // Get parking transactions
  async getTransactions(params = {}) {
    try {
      const queryString = new URLSearchParams(params).toString();
      const url = queryString ? `${this.baseURL}/parking?${queryString}` : `${this.baseURL}/parking`;
      
      const response = await fetch(url, {
        method: 'GET',
        headers: this.getHeaders(),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to get transactions: ${error.message}`);
    }
  }

  // Get transaction by ID
  async getTransaction(id) {
    try {
      const response = await fetch(`${this.baseURL}/parking/${id}`, {
        method: 'GET',
        headers: this.getHeaders(),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to get transaction: ${error.message}`);
    }
  }

  // Get print data for transaction
  async getPrintData(id) {
    try {
      const response = await fetch(`${this.baseURL}/parking/${id}/print`, {
        method: 'GET',
        headers: this.getHeaders(),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to get print data: ${error.message}`);
    }
  }

  // Get statistics
  async getStats(period = 'today') {
    try {
      const response = await fetch(`${this.baseURL}/parking/stats?period=${period}`, {
        method: 'GET',
        headers: this.getHeaders(),
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Failed to get statistics: ${error.message}`);
    }
  }

  // Health check
  async healthCheck() {
    try {
      const response = await fetch(`${this.baseURL}/health`, {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
        },
      });

      const data = await response.json();
      return data;
    } catch (error) {
      throw new Error(`Health check failed: ${error.message}`);
    }
  }
}

export default new ApiService();
