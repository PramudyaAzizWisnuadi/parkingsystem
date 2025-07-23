// context/ParkingContext.js - Fixed version
import React, { createContext, useState, useContext, useCallback } from 'react';
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
  const [vehicleTypes, setVehicleTypes] = useState([]);
  const [parkingData, setParkingData] = useState([]);
  const [pagination, setPagination] = useState(null);
  const [stats, setStats] = useState(null);
  const [loading, setLoading] = useState(false);
  const [refreshing, setRefreshing] = useState(false);

  const fetchVehicleTypes = useCallback(async () => {
    try {
      setLoading(true);
      console.log('Fetching vehicle types...');
      
      const response = await ApiService.getVehicleTypes();
      console.log('Vehicle types response:', response);
      
      if (response.success) {
        // API returns: { id, name, flat_rate, formatted_rate, is_active }
        const formattedTypes = response.data.map(type => ({
          id: type.id,
          name: type.name,
          rate: type.flat_rate,
          formatted_rate: type.formatted_rate,
          is_active: type.is_active
        }));
        
        console.log('Formatted vehicle types:', formattedTypes);
        setVehicleTypes(formattedTypes);
      } else {
        throw new Error(response.message || 'Failed to fetch vehicle types');
      }
    } catch (error) {
      console.error('Error fetching vehicle types:', error);
      // Set default vehicle types if API fails
      setVehicleTypes([
        { id: 1, name: 'Motor', rate: 2000, formatted_rate: 'Rp 2.000' },
        { id: 2, name: 'Mobil', rate: 5000, formatted_rate: 'Rp 5.000' },
        { id: 3, name: 'Truk', rate: 10000, formatted_rate: 'Rp 10.000' },
      ]);
    } finally {
      setLoading(false);
    }
  }, []);

  const fetchParkingData = useCallback(async (page = 1, filters = {}) => {
    try {
      if (page === 1) {
        setLoading(true);
      }
      
      console.log('Fetching parking data, page:', page, 'filters:', filters);
      
      const response = await ApiService.getParkingHistory(page, filters);
      console.log('Parking data response:', response);
      
      if (response.success) {
        // API returns data with vehicle_type as object: {id, name, rate}
        const formattedData = response.data.map(item => ({
          id: item.id,
          ticket_number: item.ticket_number,
          license_plate: item.license_plate,
          vehicle_type: item.vehicle_type, // Keep as object
          vehicle_type_name: item.vehicle_type?.name || 'Unknown', // Add flat name for display
          amount: item.amount,
          formatted_amount: item.formatted_amount,
          entry_time: item.entry_time,
          formatted_entry_time: item.formatted_entry_time,
          notes: item.notes,
          operator: item.operator,
          exit_time: item.exit_time || null,
        }));
        
        console.log('Formatted parking data:', formattedData.slice(0, 2)); // Log first 2 items
        
        if (page === 1) {
          setParkingData(formattedData);
        } else {
          setParkingData(prev => [...prev, ...formattedData]);
        }
        
        setPagination(response.pagination);
      } else {
        throw new Error(response.message || 'Failed to fetch parking data');
      }
    } catch (error) {
      console.error('Error fetching parking data:', error);
      if (page === 1) {
        setParkingData([]);
      }
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  }, []);

  const fetchStats = useCallback(async () => {
    try {
      console.log('Fetching stats...');
      const response = await ApiService.getStats();
      console.log('Stats response:', response);
      
      if (response.success) {
        setStats(response.data);
      }
    } catch (error) {
      console.error('Error fetching stats:', error);
      // Set default stats
      setStats({
        today_transactions: 0,
        today_revenue: 0,
        active_parkings: 0,
        available_spaces: 'N/A'
      });
    }
  }, []);

  const createParkingTransaction = useCallback(async (transactionData) => {
    try {
      setLoading(true);
      console.log('Creating parking transaction:', transactionData);
      
      const response = await ApiService.createParking(transactionData);
      console.log('Create parking response:', response);
      
      if (response.success) {
        // Refresh parking data to include new transaction
        await fetchParkingData(1);
        return response;
      } else {
        throw new Error(response.message || 'Failed to create transaction');
      }
    } catch (error) {
      console.error('Error creating parking transaction:', error);
      return {
        success: false,
        message: error.message || 'Failed to create transaction'
      };
    } finally {
      setLoading(false);
    }
  }, [fetchParkingData]);

  const refreshParkingData = useCallback(async () => {
    setRefreshing(true);
    await fetchParkingData(1);
  }, [fetchParkingData]);

  const loadMoreParkingData = useCallback(async () => {
    if (pagination && pagination.page < pagination.pages && !loading) {
      await fetchParkingData(pagination.page + 1);
    }
  }, [pagination, loading, fetchParkingData]);

  const searchParking = useCallback(async (searchTerm) => {
    try {
      setLoading(true);
      console.log('Searching parking:', searchTerm);
      
      const response = await ApiService.searchParking(searchTerm);
      console.log('Search response:', response);
      
      if (response.success) {
        const formattedData = response.data.map(item => ({
          id: item.id,
          ticket_number: item.ticket_number,
          license_plate: item.license_plate,
          vehicle_type: item.vehicle_type,
          vehicle_type_name: item.vehicle_type?.name || 'Unknown',
          amount: item.amount,
          formatted_amount: item.formatted_amount,
          entry_time: item.entry_time,
          formatted_entry_time: item.formatted_entry_time,
          notes: item.notes,
          operator: item.operator,
          exit_time: item.exit_time || null,
        }));
        
        setParkingData(formattedData);
        setPagination(null); // Clear pagination for search results
      }
    } catch (error) {
      console.error('Error searching parking:', error);
    } finally {
      setLoading(false);
    }
  }, []);

  const value = {
    vehicleTypes,
    parkingData,
    pagination,
    stats,
    loading,
    refreshing,
    fetchVehicleTypes,
    fetchParkingData,
    fetchStats,
    createParkingTransaction,
    refreshParkingData,
    loadMoreParkingData,
    searchParking,
  };

  return (
    <ParkingContext.Provider value={value}>
      {children}
    </ParkingContext.Provider>
  );
};
