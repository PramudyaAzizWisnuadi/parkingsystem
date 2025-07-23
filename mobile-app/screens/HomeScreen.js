import React, { useEffect } from 'react';
import {
  View,
  StyleSheet,
  ScrollView,
  RefreshControl,
} from 'react-native';
import {
  Card,
  Title,
  Paragraph,
  Button,
  ActivityIndicator,
  Chip,
} from 'react-native-paper';
import { useAuth } from '../context/AuthContext';
import { useParking } from '../context/ParkingContext';

export default function HomeScreen({ navigation }) {
  const { user } = useAuth();
  const { stats, loading, fetchStats, fetchVehicleTypes } = useParking();

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    await fetchStats();
    await fetchVehicleTypes();
  };

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
    }).format(amount);
  };

  const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });
  };

  return (
    <ScrollView
      style={styles.container}
      refreshControl={
        <RefreshControl refreshing={loading} onRefresh={loadData} />
      }
    >
      <Card style={styles.welcomeCard}>
        <Card.Content>
          <Title>Selamat Datang, {user?.name}!</Title>
          <Paragraph style={styles.date}>
            {formatDate(new Date())}
          </Paragraph>
          <View style={styles.roleContainer}>
            <Chip 
              icon="account-circle" 
              mode="outlined"
              style={styles.roleChip}
            >
              {user?.role === 'admin' ? 'Administrator' : 'Petugas'}
            </Chip>
          </View>
        </Card.Content>
      </Card>

      {loading && !stats ? (
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" />
          <Paragraph style={styles.loadingText}>
            Memuat data statistik...
          </Paragraph>
        </View>
      ) : (
        <>
          <Card style={styles.statsCard}>
            <Card.Content>
              <Title style={styles.statsTitle}>Statistik Hari Ini</Title>
              <View style={styles.statsGrid}>
                <View style={styles.statItem}>
                  <Title style={styles.statNumber}>
                    {stats?.today_transactions || 0}
                  </Title>
                  <Paragraph style={styles.statLabel}>
                    Transaksi
                  </Paragraph>
                </View>
                <View style={styles.statItem}>
                  <Title style={styles.statNumber}>
                    {formatCurrency(stats?.today_revenue || 0)}
                  </Title>
                  <Paragraph style={styles.statLabel}>
                    Pendapatan
                  </Paragraph>
                </View>
                <View style={styles.statItem}>
                  <Title style={styles.statNumber}>
                    {stats?.active_parkings || 0}
                  </Title>
                  <Paragraph style={styles.statLabel}>
                    Parkir Aktif
                  </Paragraph>
                </View>
                <View style={styles.statItem}>
                  <Title style={styles.statNumber}>
                    {stats?.available_spaces || 'N/A'}
                  </Title>
                  <Paragraph style={styles.statLabel}>
                    Slot Tersisa
                  </Paragraph>
                </View>
              </View>
            </Card.Content>
          </Card>

          <Card style={styles.quickActionsCard}>
            <Card.Content>
              <Title style={styles.quickActionsTitle}>Aksi Cepat</Title>
              <View style={styles.buttonGrid}>
                <Button
                  mode="contained"
                  icon="plus-circle"
                  style={styles.actionButton}
                  onPress={() => navigation.navigate('Entry')}
                >
                  Transaksi Baru
                </Button>
                <Button
                  mode="outlined"
                  icon="history"
                  style={styles.actionButton}
                  onPress={() => navigation.navigate('History')}
                >
                  Lihat Riwayat
                </Button>
              </View>
            </Card.Content>
          </Card>

          {stats?.recent_transactions && (
            <Card style={styles.recentCard}>
              <Card.Content>
                <Title style={styles.recentTitle}>Transaksi Terbaru</Title>
                {stats.recent_transactions.map((transaction) => (
                  <View key={transaction.id} style={styles.transactionItem}>
                    <View style={styles.transactionInfo}>
                      <Paragraph style={styles.licensePlate}>
                        {transaction.license_plate}
                      </Paragraph>
                      <Paragraph style={styles.vehicleType}>
                        {transaction.vehicle_type}
                      </Paragraph>
                    </View>
                    <View style={styles.transactionAmount}>
                      <Paragraph style={styles.amount}>
                        {formatCurrency(transaction.amount)}
                      </Paragraph>
                      <Paragraph style={styles.time}>
                        {new Date(transaction.entry_time).toLocaleTimeString('id-ID', {
                          hour: '2-digit',
                          minute: '2-digit',
                        })}
                      </Paragraph>
                    </View>
                  </View>
                ))}
              </Card.Content>
            </Card>
          )}
        </>
      )}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
    padding: 16,
  },
  welcomeCard: {
    marginBottom: 16,
    elevation: 2,
  },
  date: {
    fontSize: 14,
    color: '#666',
    marginTop: 4,
  },
  roleContainer: {
    marginTop: 8,
  },
  roleChip: {
    alignSelf: 'flex-start',
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 40,
  },
  loadingText: {
    marginTop: 16,
    textAlign: 'center',
  },
  statsCard: {
    marginBottom: 16,
    elevation: 2,
  },
  statsTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 16,
  },
  statsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between',
  },
  statItem: {
    width: '48%',
    alignItems: 'center',
    marginBottom: 16,
    padding: 12,
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
  },
  statNumber: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#007bff',
  },
  statLabel: {
    fontSize: 12,
    color: '#666',
    textAlign: 'center',
  },
  quickActionsCard: {
    marginBottom: 16,
    elevation: 2,
  },
  quickActionsTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 16,
  },
  buttonGrid: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  actionButton: {
    flex: 1,
    marginHorizontal: 4,
  },
  recentCard: {
    marginBottom: 16,
    elevation: 2,
  },
  recentTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 16,
  },
  transactionItem: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: 8,
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
  },
  transactionInfo: {
    flex: 1,
  },
  licensePlate: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  vehicleType: {
    fontSize: 12,
    color: '#666',
  },
  transactionAmount: {
    alignItems: 'flex-end',
  },
  amount: {
    fontWeight: 'bold',
    color: '#28a745',
  },
  time: {
    fontSize: 12,
    color: '#666',
  },
});
