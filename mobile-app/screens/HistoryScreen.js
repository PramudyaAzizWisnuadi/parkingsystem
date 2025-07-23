import React, { useState, useEffect } from 'react';
import {
  View,
  StyleSheet,
  FlatList,
  RefreshControl,
} from 'react-native';
import {
  Card,
  Title,
  Paragraph,
  Chip,
  Searchbar,
  FAB,
  ActivityIndicator,
  Button,
} from 'react-native-paper';
import { useParking } from '../context/ParkingContext';

export default function HistoryScreen({ navigation }) {
  const [searchQuery, setSearchQuery] = useState('');
  const [filteredData, setFilteredData] = useState([]);
  
  const { parkingData, loading, fetchParkingData } = useParking();

  useEffect(() => {
    if (parkingData.length === 0) {
      fetchParkingData();
    }
  }, []);

  useEffect(() => {
    filterData();
  }, [searchQuery, parkingData]);

  const filterData = () => {
    if (!searchQuery.trim()) {
      setFilteredData(parkingData);
    } else {
      const filtered = parkingData.filter(item =>
        item.license_plate.toLowerCase().includes(searchQuery.toLowerCase()) ||
        item.vehicle_type?.toLowerCase().includes(searchQuery.toLowerCase()) ||
        item.ticket_number?.toLowerCase().includes(searchQuery.toLowerCase())
      );
      setFilteredData(filtered);
    }
  };

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
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

  const getStatusColor = (exitTime) => {
    return exitTime ? '#28a745' : '#ffc107';
  };

  const getStatusText = (exitTime) => {
    return exitTime ? 'Selesai' : 'Aktif';
  };

  const renderParkingItem = ({ item }) => (
    <Card style={styles.card}>
      <Card.Content>
        <View style={styles.cardHeader}>
          <View style={styles.headerLeft}>
            <Title style={styles.licensePlate}>
              {item.license_plate}
            </Title>
            <Paragraph style={styles.vehicleType}>
              {item.vehicle_type || 'N/A'}
            </Paragraph>
          </View>
          <View style={styles.headerRight}>
            <Chip 
              style={[styles.statusChip, { backgroundColor: getStatusColor(item.exit_time) }]}
              textStyle={{ color: 'white' }}
            >
              {getStatusText(item.exit_time)}
            </Chip>
            <Paragraph style={styles.amount}>
              {formatCurrency(item.amount || 0)}
            </Paragraph>
          </View>
        </View>

        <View style={styles.cardDetails}>
          <View style={styles.detailRow}>
            <Paragraph style={styles.label}>Tiket:</Paragraph>
            <Paragraph style={styles.value}>
              {item.ticket_number || 'N/A'}
            </Paragraph>
          </View>
          
          <View style={styles.detailRow}>
            <Paragraph style={styles.label}>Masuk:</Paragraph>
            <Paragraph style={styles.value}>
              {formatDateTime(item.entry_time)}
            </Paragraph>
          </View>
          
          {item.exit_time && (
            <View style={styles.detailRow}>
              <Paragraph style={styles.label}>Keluar:</Paragraph>
              <Paragraph style={styles.value}>
                {formatDateTime(item.exit_time)}
              </Paragraph>
            </View>
          )}

          {item.operator && (
            <View style={styles.detailRow}>
              <Paragraph style={styles.label}>Operator:</Paragraph>
              <Paragraph style={styles.value}>
                {item.operator}
              </Paragraph>
            </View>
          )}

          {item.notes && (
            <View style={styles.notesContainer}>
              <Paragraph style={styles.notes}>
                {item.notes}
              </Paragraph>
            </View>
          )}
        </View>
      </Card.Content>
    </Card>
  );

  const EmptyComponent = () => (
    <View style={styles.emptyContainer}>
      <Paragraph style={styles.emptyText}>
        {searchQuery ? 'Tidak ada data yang sesuai dengan pencarian' : 'Belum ada riwayat transaksi'}
      </Paragraph>
      {!searchQuery && (
        <Button
          mode="outlined"
          onPress={() => navigation.navigate('Entry')}
          style={styles.emptyButton}
        >
          Buat Transaksi Pertama
        </Button>
      )}
    </View>
  );

  return (
    <View style={styles.container}>
      <Searchbar
        placeholder="Cari plat, jenis, atau nomor tiket..."
        onChangeText={setSearchQuery}
        value={searchQuery}
        style={styles.searchbar}
      />

      <FlatList
        data={filteredData}
        renderItem={renderParkingItem}
        keyExtractor={(item) => item.id?.toString() || Math.random().toString()}
        contentContainerStyle={styles.listContainer}
        refreshControl={
          <RefreshControl
            refreshing={loading}
            onRefresh={fetchParkingData}
          />
        }
        ListEmptyComponent={!loading ? EmptyComponent : null}
        showsVerticalScrollIndicator={false}
      />

      {loading && parkingData.length === 0 && (
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" />
          <Paragraph style={styles.loadingText}>
            Memuat riwayat transaksi...
          </Paragraph>
        </View>
      )}

      <FAB
        style={styles.fab}
        icon="plus"
        onPress={() => navigation.navigate('Entry')}
        label="Transaksi Baru"
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  searchbar: {
    margin: 16,
    marginBottom: 8,
    elevation: 2,
  },
  listContainer: {
    padding: 16,
    paddingTop: 8,
    paddingBottom: 80, // Space for FAB
  },
  card: {
    marginBottom: 12,
    elevation: 2,
  },
  cardHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: 12,
  },
  headerLeft: {
    flex: 1,
  },
  headerRight: {
    alignItems: 'flex-end',
  },
  licensePlate: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#007bff',
  },
  vehicleType: {
    fontSize: 14,
    color: '#666',
    marginTop: 2,
  },
  statusChip: {
    marginBottom: 8,
  },
  amount: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#28a745',
  },
  cardDetails: {
    marginTop: 8,
  },
  detailRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 4,
  },
  label: {
    fontSize: 14,
    color: '#666',
    flex: 1,
  },
  value: {
    fontSize: 14,
    fontWeight: '500',
    flex: 2,
    textAlign: 'right',
  },
  notesContainer: {
    marginTop: 8,
    padding: 8,
    backgroundColor: '#f8f9fa',
    borderRadius: 4,
  },
  notes: {
    fontSize: 13,
    fontStyle: 'italic',
    color: '#666',
  },
  emptyContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingVertical: 40,
  },
  emptyText: {
    fontSize: 16,
    textAlign: 'center',
    color: '#666',
    marginBottom: 16,
  },
  emptyButton: {
    marginTop: 8,
  },
  loadingContainer: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'rgba(245, 245, 245, 0.8)',
  },
  loadingText: {
    marginTop: 16,
    textAlign: 'center',
  },
  fab: {
    position: 'absolute',
    margin: 16,
    right: 0,
    bottom: 0,
  },
});
