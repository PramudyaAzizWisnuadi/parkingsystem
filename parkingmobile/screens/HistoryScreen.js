import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  FlatList,
  TouchableOpacity,
  RefreshControl,
  Alert,
  ActivityIndicator,
} from 'react-native';
import { useApp } from '../contexts/AppContext';

const HistoryScreen = () => {
  const { getTransactions, isAuthenticated } = useApp();
  const [transactions, setTransactions] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  const [refreshing, setRefreshing] = useState(false);
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);

  useEffect(() => {
    if (isAuthenticated) {
      loadTransactions();
    }
  }, [isAuthenticated]); // eslint-disable-line react-hooks/exhaustive-deps

  const loadTransactions = async (pageNumber = 1, refresh = false) => {
    if (!isAuthenticated) return;

    try {
      if (refresh) {
        setRefreshing(true);
      } else {
        setIsLoading(true);
      }

      const response = await getTransactions({
        page: pageNumber,
        limit: 20,
      });

      if (response.success) {
        const newTransactions = response.data || [];
        
        if (refresh || pageNumber === 1) {
          setTransactions(newTransactions);
        } else {
          setTransactions(prev => [...prev, ...newTransactions]);
        }

        const pagination = response.pagination || {};
        setHasMore(pageNumber < (pagination.pages || 0));
        setPage(pageNumber);
      } else {
        Alert.alert('Error', response.message || 'Gagal memuat riwayat');
      }
    } catch (error) {
      Alert.alert('Error', `Gagal memuat riwayat: ${error.message}`);
    } finally {
      setIsLoading(false);
      setRefreshing(false);
    }
  };

  const onRefresh = () => {
    loadTransactions(1, true);
  };

  const loadMore = () => {
    if (!isLoading && hasMore) {
      loadTransactions(page + 1);
    }
  };

  const formatCurrency = (amount) => {
    return `Rp ${amount?.toLocaleString('id-ID') || '0'}`;
  };

  const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });
  };

  const TransactionItem = ({ item }) => (
    <View style={styles.transactionItem}>
      <View style={styles.transactionHeader}>
        <Text style={styles.ticketNumber}>{item.ticket_number}</Text>
        <Text style={styles.amount}>{item.formatted_amount}</Text>
      </View>
      
      <View style={styles.transactionDetails}>
        <Text style={styles.vehicleType}>{item.vehicle_type?.name}</Text>
        {item.license_plate && (
          <Text style={styles.licensePlate}>• {item.license_plate}</Text>
        )}
      </View>
      
      <Text style={styles.entryTime}>
        {formatDate(item.entry_time)}
      </Text>
      
      {item.notes && (
        <Text style={styles.notes}>{item.notes}</Text>
      )}
    </View>
  );

  const EmptyState = () => (
    <View style={styles.emptyState}>
      {!isAuthenticated ? (
        <>
          <Text style={styles.emptyTitle}>Login Diperlukan</Text>
          <Text style={styles.emptySubtitle}>
            Anda perlu login untuk melihat riwayat transaksi
          </Text>
        </>
      ) : (
        <>
          <Text style={styles.emptyTitle}>Belum Ada Transaksi</Text>
          <Text style={styles.emptySubtitle}>
            Riwayat transaksi akan muncul di sini
          </Text>
        </>
      )}
    </View>
  );

  const LoadingFooter = () => {
    if (!isLoading || refreshing) return null;
    
    return (
      <View style={styles.loadingFooter}>
        <ActivityIndicator size="small" color="#2196F3" />
      </View>
    );
  };

  return (
    <View style={styles.container}>
      <View style={styles.header}>
        <Text style={styles.title}>Riwayat Transaksi</Text>
        {!isAuthenticated && (
          <Text style={styles.loginRequired}>Login untuk melihat riwayat</Text>
        )}
      </View>

      {!isAuthenticated || transactions.length === 0 ? (
        <EmptyState />
      ) : (
        <FlatList
          data={transactions}
          renderItem={({ item }) => <TransactionItem item={item} />}
          keyExtractor={(item) => item.id?.toString() || Math.random().toString()}
          refreshControl={
            <RefreshControl
              refreshing={refreshing}
              onRefresh={onRefresh}
              colors={['#2196F3']}
            />
          }
          onEndReached={loadMore}
          onEndReachedThreshold={0.1}
          ListFooterComponent={LoadingFooter}
          contentContainerStyle={styles.listContainer}
        />
      )}

      {isAuthenticated && (
        <TouchableOpacity
          style={styles.refreshButton}
          onPress={onRefresh}
          disabled={refreshing || isLoading}
        >
          <Text style={styles.refreshButtonText}>
            {refreshing ? 'Memuat...' : 'Refresh'}
          </Text>
        </TouchableOpacity>
      )}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  header: {
    backgroundColor: '#2196F3',
    padding: 20,
    paddingTop: 50,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#fff',
    textAlign: 'center',
  },
  loginRequired: {
    fontSize: 14,
    color: '#fff',
    textAlign: 'center',
    marginTop: 5,
    opacity: 0.8,
  },
  listContainer: {
    padding: 16,
  },
  transactionItem: {
    backgroundColor: '#fff',
    padding: 16,
    marginBottom: 8,
    borderRadius: 8,
    elevation: 2,
  },
  transactionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 8,
  },
  ticketNumber: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#333',
  },
  amount: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#4CAF50',
  },
  transactionDetails: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 8,
  },
  vehicleType: {
    fontSize: 14,
    color: '#666',
  },
  licensePlate: {
    fontSize: 14,
    color: '#666',
    marginLeft: 8,
  },
  entryTime: {
    fontSize: 12,
    color: '#999',
    marginBottom: 4,
  },
  notes: {
    fontSize: 12,
    color: '#666',
    fontStyle: 'italic',
    marginTop: 4,
  },
  emptyState: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 40,
  },
  emptyTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 8,
    textAlign: 'center',
  },
  emptySubtitle: {
    fontSize: 16,
    color: '#666',
    textAlign: 'center',
    lineHeight: 24,
  },
  loadingFooter: {
    padding: 20,
    alignItems: 'center',
  },
  refreshButton: {
    backgroundColor: '#2196F3',
    margin: 16,
    padding: 12,
    borderRadius: 8,
    alignItems: 'center',
  },
  refreshButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default HistoryScreen;
