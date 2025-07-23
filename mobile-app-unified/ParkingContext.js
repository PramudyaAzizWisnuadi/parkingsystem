// context/ParkingContext.js - Unified version with Web compatibility
import React, { createContext, useContext, useState, useCallback, useEffect } from 'react';
import ApiService from '../services/ApiService';

const ParkingContext = createContext();

export const useParkingContext = () => {
  const context = useContext(ParkingContext);
  if (!context) {
    throw new Error('useParkingContext must be used within a ParkingProvider');
  }
  return context;
};

export const ParkingProvider = ({ children }) => {
  const [vehicleTypes, setVehicleTypes] = useState([]);
  const [parkingData, setParkingData] = useState([]);
  const [statistics, setStatistics] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState({
    current_page: 1,
    total_pages: 1,
    per_page: 10,
    total: 0
  });

  const clearError = () => setError(null);

  // Fetch Vehicle Types - Unified format handler
  const fetchVehicleTypes = useCallback(async () => {
    try {
      setLoading(true);
      setError(null);
      
      console.log('Fetching vehicle types...');
      const response = await ApiService.getVehicleTypes();
      console.log('Vehicle types response:', response);
      
      if (response.success) {
        // Ensure unified format for both web and mobile compatibility
        const formattedTypes = response.data.map(type => ({
          id: type.id,
          name: type.name,
          // Support both flat_rate (web) and rate (mobile)
          rate: type.rate || type.flat_rate,
          flat_rate: type.flat_rate || type.rate,
          formatted_rate: type.formatted_rate,
          is_active: type.is_active,
        }));
        
        console.log('Formatted vehicle types:', formattedTypes);
        setVehicleTypes(formattedTypes);
      } else {
        throw new Error(response.message || 'Failed to fetch vehicle types');
      }
    } catch (error) {
      console.error('Error fetching vehicle types:', error);
      setError(`Failed to load vehicle types: ${error.message}`);
      
      // Fallback to demo data with unified format
      console.log('Using fallback demo data');
      setVehicleTypes([
        { id: 1, name: 'Motor', rate: 2000, flat_rate: 2000, formatted_rate: 'Rp 2.000', is_active: true },
        { id: 2, name: 'Mobil', rate: 5000, flat_rate: 5000, formatted_rate: 'Rp 5.000', is_active: true },
        { id: 3, name: 'Truk', rate: 10000, flat_rate: 10000, formatted_rate: 'Rp 10.000', is_active: true },
      ]);
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch Parking Data - Unified format handler
  const fetchParkingData = useCallback(async (page = 1, filters = {}) => {
    try {
      if (page === 1) {
        setLoading(true);
        setError(null);
      }
      
      console.log('Fetching parking data, page:', page, 'filters:', filters);
      
      const response = await ApiService.getParkingHistory(page, filters);
      console.log('Parking data response:', response);
      
      if (response.success) {
        // Ensure unified format for transaction data
        const formattedData = response.data.map(item => ({
          id: item.id,
          ticket_number: item.ticket_number,
          license_plate: item.license_plate,
          // Unified vehicle_type format
          vehicle_type: {
            id: item.vehicle_type.id,
            name: item.vehicle_type.name,
            rate: item.vehicle_type.rate || item.vehicle_type.flat_rate,
            flat_rate: item.vehicle_type.flat_rate || item.vehicle_type.rate,
          },
          // Convenience field for display
          vehicle_type_name: item.vehicle_type?.name || 'Unknown',
          amount: item.amount,
          formatted_amount: item.formatted_amount,
          entry_time: item.entry_time,
          formatted_entry_time: item.formatted_entry_time,
          notes: item.notes,
          operator: item.operator,
          exit_time: item.exit_time || null,
        }));
        
        console.log('Formatted parking data sample:', formattedData.slice(0, 2));
        
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
      setError(`Failed to load parking history: ${error.message}`);
      
      if (page === 1) {
        setParkingData([]);
        setPagination({
          current_page: 1,
          total_pages: 1,
          per_page: 10,
          total: 0
        });
      }
    } finally {
      setLoading(false);
    }
  }, []);

  // Create Parking Transaction - Unified format
  const createParkingTransaction = useCallback(async (transactionData) => {
    try {
      setLoading(true);
      setError(null);
      
      console.log('Creating parking transaction:', transactionData);
      
      const response = await ApiService.createParkingTransaction(transactionData);
      console.log('Create transaction response:', response);
      
      if (response.success) {
        // Format the response data for unified compatibility
        const formattedTransaction = {
          ...response.data,
          vehicle_type: {
            ...response.data.vehicle_type,
            rate: response.data.vehicle_type.rate || response.data.vehicle_type.flat_rate,
            flat_rate: response.data.vehicle_type.flat_rate || response.data.vehicle_type.rate,
          }
        };
        
        // Add to the beginning of parking data
        setParkingData(prev => [formattedTransaction, ...prev]);
        
        return response;
      } else {
        throw new Error(response.message || 'Failed to create parking transaction');
      }
    } catch (error) {
      console.error('Error creating parking transaction:', error);
      setError(`Failed to create transaction: ${error.message}`);
      throw error;
    } finally {
      setLoading(false);
    }
  }, []);

  // Fetch Statistics
  const fetchStatistics = useCallback(async (period = 'today') => {
    try {
      console.log('Fetching statistics for period:', period);
      
      const response = await ApiService.getStatistics(period);
      console.log('Statistics response:', response);
      
      if (response.success) {
        setStatistics(response.data);
      } else {
        throw new Error(response.message || 'Failed to fetch statistics');
      }
    } catch (error) {
      console.error('Error fetching statistics:', error);
      setError(`Failed to load statistics: ${error.message}`);
    }
  }, []);

  // Refresh all data
  const refreshAllData = useCallback(async () => {
    await Promise.all([
      fetchVehicleTypes(),
      fetchParkingData(1),
      fetchStatistics()
    ]);
  }, [fetchVehicleTypes, fetchParkingData, fetchStatistics]);

  // Load more parking data (pagination)
  const loadMoreParkingData = useCallback(() => {
    if (pagination.current_page < pagination.total_pages && !loading) {
      fetchParkingData(pagination.current_page + 1);
    }
  }, [pagination, loading, fetchParkingData]);

  // Search parking data
  const searchParkingData = useCallback(async (searchTerm) => {
    const filters = {};
    if (searchTerm) {
      filters.search = searchTerm;
    }
    await fetchParkingData(1, filters);
  }, [fetchParkingData]);

  // Initialize data on mount
  useEffect(() => {
    fetchVehicleTypes();
    fetchParkingData(1);
    fetchStatistics();
  }, [fetchVehicleTypes, fetchParkingData, fetchStatistics]);

  // Helper function to get vehicle type by ID
  const getVehicleTypeById = useCallback((id) => {
    return vehicleTypes.find(type => type.id === id);
  }, [vehicleTypes]);

  // Helper function to format amount
  const formatAmount = useCallback((amount) => {
    return `Rp ${new Intl.NumberFormat('id-ID').format(amount)}`;
  }, []);

  const value = {
    // State
    vehicleTypes,
    parkingData,
    statistics,
    loading,
    error,
    pagination,
    
    // Actions
    fetchVehicleTypes,
    fetchParkingData,
    createParkingTransaction,
    fetchStatistics,
    refreshAllData,
    loadMoreParkingData,
    searchParkingData,
    clearError,
    
    // Helpers
    getVehicleTypeById,
    formatAmount,
  };

  return (
    <ParkingContext.Provider value={value}>
      {children}
    </ParkingContext.Provider>
  );
};
