import React, { createContext, useContext, useState, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import ApiService from '../services/ApiService';

const AppContext = createContext();

export const useApp = () => {
  const context = useContext(AppContext);
  if (!context) {
    throw new Error('useApp must be used within AppProvider');
  }
  return context;
};

export const AppProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [isLoading, setIsLoading] = useState(true);
  const [vehicleTypes, setVehicleTypes] = useState([]);

  // Load stored auth data on app start
  useEffect(() => {
    loadAuthData();
    loadVehicleTypes();
  }, []);

  const loadAuthData = async () => {
    try {
      const storedToken = await AsyncStorage.getItem('auth_token');
      const storedUser = await AsyncStorage.getItem('user_data');

      if (storedToken && storedUser) {
        ApiService.setToken(storedToken);
        setUser(JSON.parse(storedUser));
        setIsAuthenticated(true);
      }
    } catch (error) {
      console.error('Failed to load auth data:', error);
    } finally {
      setIsLoading(false);
    }
  };

  const loadVehicleTypes = async () => {
    try {
      // Coba load vehicle types dengan auth terlebih dahulu
      let response = await ApiService.getVehicleTypes();
      
      // Jika gagal, coba dengan demo endpoint
      if (!response.success) {
        response = await ApiService.getDemoVehicleTypes();
      }

      if (response.success && response.data) {
        setVehicleTypes(response.data);
      } else {
        // Fallback ke data static jika API tidak tersedia
        setVehicleTypes([
          { id: 1, name: 'Motor', flat_rate: 2000, rate: 2000 },
          { id: 2, name: 'Mobil', flat_rate: 5000, rate: 5000 },
          { id: 3, name: 'Truk', flat_rate: 10000, rate: 10000 },
        ]);
      }
    } catch (error) {
      console.error('Failed to load vehicle types:', error);
      // Fallback ke data static
      setVehicleTypes([
        { id: 1, name: 'Motor', flat_rate: 2000, rate: 2000 },
        { id: 2, name: 'Mobil', flat_rate: 5000, rate: 5000 },
        { id: 3, name: 'Truk', flat_rate: 10000, rate: 10000 },
      ]);
    }
  };

  const login = async (email, password) => {
    try {
      setIsLoading(true);
      const response = await ApiService.login(email, password);

      if (response.success) {
        await AsyncStorage.setItem('auth_token', response.token);
        await AsyncStorage.setItem('user_data', JSON.stringify(response.user));
        
        setUser(response.user);
        setIsAuthenticated(true);
        
        // Reload vehicle types setelah login
        await loadVehicleTypes();
        
        return { success: true };
      } else {
        return { success: false, message: response.message || 'Login failed' };
      }
    } catch (error) {
      return { success: false, message: error.message };
    } finally {
      setIsLoading(false);
    }
  };

  const logout = async () => {
    try {
      setIsLoading(true);
      
      // Coba logout dari server
      try {
        await ApiService.logout();
      } catch (error) {
        console.log('Server logout failed, continuing with local logout:', error);
      }

      // Clear local storage
      await AsyncStorage.removeItem('auth_token');
      await AsyncStorage.removeItem('user_data');
      
      // Clear states
      ApiService.setToken(null);
      setUser(null);
      setIsAuthenticated(false);
      
      // Reload vehicle types untuk mode demo
      await loadVehicleTypes();
      
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      setIsLoading(false);
    }
  };

  const createTransaction = async (transactionData) => {
    try {
      let response;
      
      if (isAuthenticated) {
        response = await ApiService.createTransaction(transactionData);
      } else {
        response = await ApiService.createDemoTransaction(transactionData);
      }

      return response;
    } catch (error) {
      throw error;
    }
  };

  const getTransactions = async (params = {}) => {
    try {
      const response = await ApiService.getTransactions(params);
      return response;
    } catch (error) {
      throw error;
    }
  };

  const getStats = async (period = 'today') => {
    try {
      const response = await ApiService.getStats(period);
      return response;
    } catch (error) {
      throw error;
    }
  };

  const getPrintData = async (transactionId) => {
    try {
      const response = await ApiService.getPrintData(transactionId);
      return response;
    } catch (error) {
      throw error;
    }
  };

  const value = {
    // State
    user,
    isAuthenticated,
    isLoading,
    vehicleTypes,
    
    // Actions
    login,
    logout,
    createTransaction,
    getTransactions,
    getStats,
    getPrintData,
    loadVehicleTypes,
  };

  return (
    <AppContext.Provider value={value}>
      {children}
    </AppContext.Provider>
  );
};
