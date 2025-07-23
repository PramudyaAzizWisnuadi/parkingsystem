// screens/HistoryScreen.js - Unified version with Web compatibility
import React, { useState, useEffect, useCallback } from 'react';
import {
  View,
  Text,
  FlatList,
  StyleSheet,
  RefreshControl,
  Alert,
  TextInput,
} from 'react-native';
import { Card, Button, Chip, FAB, Searchbar } from 'react-native-paper';
import { useParkingContext } from '../context/ParkingContext';

const HistoryScreen = ({ navigation }) => {
  const {
    parkingData,
    loading,
    error,
    pagination,
    fetchParkingData,
    loadMoreParkingData,
    searchParkingData,
    clearError,
  } = useParkingContext();

  const [searchQuery, setSearchQuery] = useState('');
  const [refreshing, setRefreshing] = useState(false);

  useEffect(() => {
    if (error) {
      Alert.alert('Error', error);
      clearError();
    }
  }, [error, clearError]);

  const handleRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchParkingData(1);
    setRefreshing(false);
  }, [fetchParkingData]);

  const handleSearch = useCallback(async (query) => {
    setSearchQuery(query);
    if (query.trim()) {
      await searchParkingData(query.trim());
    } else {
      await fetchParkingData(1);
    }
  }, [searchParkingData, fetchParkingData]);

  const handleLoadMore = useCallback(() => {
    if (pagination.current_page < pagination.total_pages && !loading) {
      loadMoreParkingData();
    }
  }, [pagination, loading, loadMoreParkingData]);

  const renderTransactionItem = ({ item, index }) => {
    // Support unified format - handle both rate and flat_rate
    const vehicleRate = item.vehicle_type?.rate || item.vehicle_type?.flat_rate;
    const vehicleFormattedRate = item.vehicle_type?.formatted_rate || 
      (vehicleRate ? `Rp ${new Intl.NumberFormat('id-ID').format(vehicleRate)}` : '');

    return (
      <Card style={styles.card} key={`${item.id}-${index}`}>
        <Card.Content>
          <View style={styles.cardHeader}>
            <Text style={styles.ticketNumber}>{item.ticket_number}</Text>
            <Text style={styles.dateTime}>
              {item.formatted_entry_time || new Date(item.entry_time).toLocaleString('id-ID')}
            </Text>
          </View>
          
          <View style={styles.cardBody}>
            <View style={styles.row}>
              <Text style={styles.label}>Plat Nomor:</Text>
              <Text style={styles.value}>
                {item.license_plate || 'Tidak ada'}
              </Text>
            </View>
            
            <View style={styles.row}>
              <Text style={styles.label}>Jenis Kendaraan:</Text>
              <Chip mode="outlined" style={styles.vehicleChip}>
                {item.vehicle_type_name || item.vehicle_type?.name || 'Unknown'}
              </Chip>
            </View>
            
            <View style={styles.row}>
              <Text style={styles.label}>Tarif:</Text>
              <Text style={styles.rateText}>
                {vehicleFormattedRate}
              </Text>
            </View>
            
            <View style={styles.row}>
              <Text style={styles.label}>Total Bayar:</Text>
              <Text style={styles.amount}>
                {item.formatted_amount || `Rp ${new Intl.NumberFormat('id-ID').format(item.amount)}`}
              </Text>
            </View>
            
            {item.notes && (
              <View style={styles.row}>
                <Text style={styles.label}>Catatan:</Text>
                <Text style={styles.notes}>{item.notes}</Text>
              </View>
            )}
            
            <View style={styles.row}>
              <Text style={styles.label}>Operator:</Text>
              <Text style={styles.operator}>{item.operator || 'Unknown'}</Text>
            </View>
          </View>
        </Card.Content>
      </Card>
    );
  };

  const renderEmptyState = () => (
    <View style={styles.emptyState}>
      <Text style={styles.emptyText}>Tidak ada data transaksi</Text>
      <Text style={styles.emptySubtext}>
        Transaksi parkir yang dibuat akan muncul di sini
      </Text>
      <Button 
        mode="outlined" 
        onPress={() => navigation.navigate('ParkingEntry')}
        style={styles.emptyButton}
      >
        Buat Transaksi Baru
      </Button>
    </View>
  );

  const renderFooter = () => {
    if (loading && parkingData.length > 0) {
      return (
        <View style={styles.loadingFooter}>
          <Text>Loading more...</Text>
        </View>
      );
    }
    
    if (pagination.current_page >= pagination.total_pages && parkingData.length > 0) {
      return (
        <View style={styles.loadingFooter}>
          <Text style={styles.endText}>--- End of data ---</Text>
        </View>
      );
    }
    
    return null;
  };

  return (
    <View style={styles.container}>
      {/* Search Bar */}
      <View style={styles.searchContainer}>
        <Searchbar
          placeholder="Cari nomor tiket atau plat..."
          onChangeText={handleSearch}
          value={searchQuery}
          style={styles.searchbar}
        />
      </View>

      {/* Statistics */}
      <View style={styles.statsContainer}>
        <Text style={styles.statsText}>
          Total: {pagination.total} transaksi
        </Text>
        <Text style={styles.statsText}>
          Halaman {pagination.current_page} dari {pagination.total_pages}
        </Text>
      </View>

      {/* Transaction List */}
      <FlatList
        data={parkingData}
        renderItem={renderTransactionItem}
        keyExtractor={(item, index) => `${item.id}-${index}`}
        contentContainerStyle={parkingData.length === 0 ? styles.emptyContainer : styles.listContainer}
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={handleRefresh} />
        }
        onEndReached={handleLoadMore}
        onEndReachedThreshold={0.1}
        ListEmptyComponent={!loading ? renderEmptyState : null}
        ListFooterComponent={renderFooter}
        showsVerticalScrollIndicator={false}
        removeClippedSubviews={true}
        maxToRenderPerBatch={10}
        updateCellsBatchingPeriod={50}
        initialNumToRender={10}
        windowSize={10}
      />

      {/* Add New Transaction FAB */}
      <FAB
        icon="plus"
        style={styles.fab}
        onPress={() => navigation.navigate('ParkingEntry')}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  searchContainer: {
    padding: 16,
    paddingBottom: 8,
  },
  searchbar: {
    elevation: 2,
  },
  statsContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingHorizontal: 16,
    paddingVertical: 8,
    backgroundColor: '#fff',
    borderBottomWidth: 1,
    borderBottomColor: '#e0e0e0',
  },
  statsText: {
    fontSize: 12,
    color: '#666',
  },
  listContainer: {
    padding: 16,
  },
  emptyContainer: {
    flexGrow: 1,
    justifyContent: 'center',
  },
  card: {
    marginBottom: 12,
    elevation: 2,
    backgroundColor: '#fff',
  },
  cardHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 12,
    paddingBottom: 8,
    borderBottomWidth: 1,
    borderBottomColor: '#f0f0f0',
  },
  ticketNumber: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#1976d2',
  },
  dateTime: {
    fontSize: 12,
    color: '#666',
  },
  cardBody: {
    gap: 8,
  },
  row: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: 2,
  },
  label: {
    fontSize: 14,
    color: '#666',
    flex: 1,
  },
  value: {
    fontSize: 14,
    color: '#333',
    flex: 1,
    textAlign: 'right',
  },
  vehicleChip: {
    backgroundColor: '#e3f2fd',
  },
  rateText: {
    fontSize: 14,
    color: '#1976d2',
    fontWeight: '500',
  },
  amount: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#2e7d32',
  },
  notes: {
    fontSize: 14,
    color: '#333',
    fontStyle: 'italic',
    flex: 1,
    textAlign: 'right',
  },
  operator: {
    fontSize: 12,
    color: '#666',
  },
  emptyState: {
    alignItems: 'center',
    paddingVertical: 60,
    paddingHorizontal: 40,
  },
  emptyText: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#666',
    marginBottom: 8,
    textAlign: 'center',
  },
  emptySubtext: {
    fontSize: 14,
    color: '#999',
    textAlign: 'center',
    marginBottom: 20,
    lineHeight: 20,
  },
  emptyButton: {
    marginTop: 10,
  },
  loadingFooter: {
    padding: 16,
    alignItems: 'center',
  },
  endText: {
    color: '#999',
    fontStyle: 'italic',
  },
  fab: {
    position: 'absolute',
    margin: 16,
    right: 0,
    bottom: 0,
    backgroundColor: '#6200ee',
  },
});

export default HistoryScreen;
