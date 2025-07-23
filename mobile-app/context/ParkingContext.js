import React, { createContext, useState, useContext } from 'react';
import ApiService from '../services/ApiService';

const ParkingContext = createContext();

export const useParking = () => {
  const context = useContext(ParkingContext);
  if (!context) {
    throw new Error('useParking must be used within a ParkingProvider');
  }
  return context;
};

export const ParkingProvider = ({ children }) => {
  const [parkingData, setParkingData] = useState([]);
  const [vehicleTypes, setVehicleTypes] = useState([]);
  const [loading, setLoading] = useState(false);
  const [stats, setStats] = useState(null);

  const fetchVehicleTypes = async () => {
    try {
      setLoading(true);
      const response = await ApiService.get('/demo/vehicle-types');
      if (response.data.success) {
        setVehicleTypes(response.data.data);
      }
    } catch (error) {
      console.error('Error fetching vehicle types:', error);
    } finally {
      setLoading(false);
    }
  };

  const fetchParkingData = async () => {
    try {
      setLoading(true);
      const response = await ApiService.get('/parking');
      if (response.data.success) {
        setParkingData(response.data.data);
      }
    } catch (error) {
      console.error('Error fetching parking data:', error);
    } finally {
      setLoading(false);
    }
  };

  const fetchStats = async () => {
    try {
      const response = await ApiService.get('/stats');
      if (response.data.success) {
        setStats(response.data.data);
      }
    } catch (error) {
      console.error('Error fetching stats:', error);
    }
  };

  const createParkingTransaction = async (transactionData) => {
    try {
      setLoading(true);
      const response = await ApiService.post('/demo/parking', transactionData);
      if (response.data.success) {
        // Update local data
        await fetchParkingData();
        return { success: true, data: response.data.data };
      }
    } catch (error) {
      console.error('Error creating parking transaction:', error);
      return { 
        success: false, 
        message: error.response?.data?.message || 'Failed to create transaction' 
      };
    } finally {
      setLoading(false);
    }
  };

  const value = {
    parkingData,
    vehicleTypes,
    stats,
    loading,
    fetchVehicleTypes,
    fetchParkingData,
    fetchStats,
    createParkingTransaction,
  };

  return (
    <ParkingContext.Provider value={value}>
      {children}
    </ParkingContext.Provider>
  );
};
