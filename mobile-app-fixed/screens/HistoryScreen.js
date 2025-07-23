// screens/HistoryScreen.js - Fixed version
import React, { useState, useEffect, useCallback } from 'react';
import {
  View,
  FlatList,
  StyleSheet,
  RefreshControl,
} from 'react-native';
import {
  Text,
  Card,
  Searchbar,
  ActivityIndicator,
  Button,
  Chip,
  IconButton,
} from 'react-native-paper';
import { useParking } from '../context/ParkingContext';

const HistoryScreen = ({ navigation }) => {
  const {
    parkingData,
    pagination,
    loading,
    refreshing,
    fetchParkingData,
    refreshParkingData,
    loadMoreParkingData,
    searchParking,
  } = useParking();

  const [searchQuery, setSearchQuery] = useState('');
  const [filter, setFilter] = useState('all'); // all, active, completed

  useEffect(() => {
    console.log('HistoryScreen: Component mounted');
    loadInitialData();
  }, []);

  useEffect(() => {
    console.log('HistoryScreen: Parking data updated:', parkingData.length, 'items');
    console.log('HistoryScreen: Sample data:', parkingData.slice(0, 2));
  }, [parkingData]);

  const loadInitialData = async () => {
    console.log('HistoryScreen: Loading initial data');
    await fetchParkingData(1);
  };

  const onChangeSearch = (query) => {
    setSearchQuery(query);
  };

  const onSubmitSearch = async () => {
    if (searchQuery.trim()) {
      console.log('HistoryScreen: Searching for:', searchQuery.trim());
      await searchParking(searchQuery.trim());
    } else {
      console.log('HistoryScreen: Clearing search, loading all data');
      await fetchParkingData(1);
    }
  };

  const handleFilterChange = async (newFilter) => {
    console.log('HistoryScreen: Filter changed to:', newFilter);
    setFilter(newFilter);
    const filters = newFilter === 'all' ? {} : { status: newFilter };
    await fetchParkingData(1, filters);
  };

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
    }).format(amount);
  };

  const formatDateTime = (dateString) => {
    return new Date(dateString).toLocaleString('id-ID', {
      year: 'numeric',
      month: '2-digit',
      day: '2-digit',
      hour: '2-digit',
      minute: '2-digit',
    });
  };

  const getStatusChip = (item) => {
    const isActive = !item.exit_time;
    return (
      <Chip
        icon={isActive ? 'clock' : 'check-circle'}
        style={[
          styles.statusChip,
          { backgroundColor: isActive ? '#e3f2fd' : '#e8f5e8' },
        ]}
        textStyle={{ color: isActive ? '#1976d2' : '#2e7d32' }}
      >
        {isActive ? 'Aktif' : 'Selesai'}
      </Chip>
    );
  };

  const renderParkingItem = ({ item }) => {
    console.log('HistoryScreen: Rendering item:', item.id, item.vehicle_type);
    
    return (
      <Card style={styles.card}>
        <Card.Content>
          <View style={styles.cardHeader}>
            <Text variant="titleMedium" style={styles.ticketNumber}>
              {item.ticket_number || 'No Ticket'}
            </Text>
            {getStatusChip(item)}
          </View>

          <View style={styles.cardRow}>
            <Text variant="bodyMedium" style={styles.label}>
              Plat Nomor:
            </Text>
            <Text variant="bodyMedium" style={styles.value}>
              {item.license_plate || 'Tidak ada'}
            </Text>
          </View>

          <View style={styles.cardRow}>
            <Text variant="bodyMedium" style={styles.label}>
              Jenis Kendaraan:
            </Text>
            <Text variant="bodyMedium" style={styles.value}>
              {item.vehicle_type_name || item.vehicle_type?.name || 'Unknown'}
            </Text>
          </View>

          <View style={styles.cardRow}>
            <Text variant="bodyMedium" style={styles.label}>
              Tarif:
            </Text>
            <Text variant="bodyMedium" style={[styles.value, styles.price]}>
              {item.formatted_amount || formatCurrency(item.amount || 0)}
            </Text>
          </View>

          <View style={styles.cardRow}>
            <Text variant="bodyMedium" style={styles.label}>
              Waktu Masuk:
            </Text>
            <Text variant="bodyMedium" style={styles.value}>
              {item.formatted_entry_time || formatDateTime(item.entry_time)}
            </Text>
          </View>

          {item.exit_time && (
            <View style={styles.cardRow}>
              <Text variant="bodyMedium" style={styles.label}>
                Waktu Keluar:
              </Text>
              <Text variant="bodyMedium" style={styles.value}>
                {formatDateTime(item.exit_time)}
              </Text>
            </View>
          )}

          {item.operator && (
            <View style={styles.cardRow}>
              <Text variant="bodyMedium" style={styles.label}>
                Operator:
              </Text>
              <Text variant="bodyMedium" style={styles.value}>
                {item.operator}
              </Text>
            </View>
          )}

          {item.notes && (
            <View style={styles.cardRow}>
              <Text variant="bodyMedium" style={styles.label}>
                Catatan:
              </Text>
              <Text variant="bodyMedium" style={styles.value}>
                {item.notes}
              </Text>
            </View>
          )}
        </Card.Content>
      </Card>
    );
  };

  const renderLoadMoreButton = () => {
    if (!pagination || pagination.page >= pagination.pages) return null;

    return (
      <Button
        mode="outlined"
        onPress={loadMoreParkingData}
        loading={loading}
        style={styles.loadMoreButton}
      >
        Load More ({pagination.total - parkingData.length} remaining)
      </Button>
    );
  };

  const renderEmptyState = () => (
    <View style={styles.emptyState}>
      <Text variant="bodyLarge" style={styles.emptyText}>
        {searchQuery ? 'Tidak ada data yang sesuai dengan pencarian' : 'Tidak ada data transaksi'}
      </Text>
      {!searchQuery && (
        <Button mode="contained" onPress={loadInitialData} style={styles.retryButton}>
          Coba Lagi
        </Button>
      )}
    </View>
  );

  if (loading && parkingData.length === 0) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" />
        <Text variant="bodyLarge" style={styles.loadingText}>
          Memuat riwayat transaksi...
        </Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Searchbar
        placeholder="Cari plat nomor..."
        onChangeText={onChangeSearch}
        value={searchQuery}
        onSubmitEditing={onSubmitSearch}
        style={styles.searchBar}
      />

      <View style={styles.filterContainer}>
        <Chip
          selected={filter === 'all'}
          onPress={() => handleFilterChange('all')}
          style={styles.filterChip}
        >
          Semua
        </Chip>
        <Chip
          selected={filter === 'active'}
          onPress={() => handleFilterChange('active')}
          style={styles.filterChip}
        >
          Aktif
        </Chip>
        <Chip
          selected={filter === 'completed'}
          onPress={() => handleFilterChange('completed')}
          style={styles.filterChip}
        >
          Selesai
        </Chip>
      </View>

      {parkingData.length > 0 && (
        <View style={styles.infoContainer}>
          <Text variant="bodyMedium" style={styles.infoText}>
            Menampilkan {parkingData.length} dari {pagination?.total || 0} transaksi
          </Text>
        </View>
      )}

      <FlatList
        data={parkingData}
        renderItem={renderParkingItem}
        keyExtractor={(item) => item.id.toString()}
        refreshControl={
          <RefreshControl refreshing={refreshing} onRefresh={refreshParkingData} />
        }
        ListEmptyComponent={renderEmptyState}
        ListFooterComponent={renderLoadMoreButton}
        contentContainerStyle={
          parkingData.length === 0 ? styles.emptyContainer : styles.listContainer
        }
        showsVerticalScrollIndicator={false}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  searchBar: {
    margin: 16,
  },
  filterContainer: {
    flexDirection: 'row',
    paddingHorizontal: 16,
    paddingBottom: 8,
  },
  filterChip: {
    marginRight: 8,
  },
  infoContainer: {
    paddingHorizontal: 16,
    paddingBottom: 8,
  },
  infoText: {
    color: '#666',
    fontStyle: 'italic',
  },
  listContainer: {
    paddingBottom: 16,
  },
  emptyContainer: {
    flex: 1,
  },
  card: {
    marginHorizontal: 16,
    marginVertical: 8,
    elevation: 2,
  },
  cardHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 12,
  },
  ticketNumber: {
    fontWeight: 'bold',
    color: '#1976d2',
  },
  statusChip: {
    borderRadius: 16,
  },
  cardRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 6,
  },
  label: {
    fontWeight: '500',
    color: '#666',
    flex: 1,
  },
  value: {
    flex: 1.5,
    textAlign: 'right',
  },
  price: {
    fontWeight: 'bold',
    color: '#2e7d32',
  },
  loadMoreButton: {
    margin: 16,
  },
  emptyState: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 32,
  },
  emptyText: {
    textAlign: 'center',
    marginBottom: 16,
  },
  retryButton: {
    marginTop: 16,
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loadingText: {
    marginTop: 16,
  },
});

export default HistoryScreen;
