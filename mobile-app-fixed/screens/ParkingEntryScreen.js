// screens/ParkingEntryScreen.js - Fixed version
import React, { useState, useEffect } from 'react';
import {
  View,
  StyleSheet,
  ScrollView,
  Alert,
} from 'react-native';
import {
  Text,
  TextInput,
  Button,
  Card,
  RadioButton,
  ActivityIndicator,
  Snackbar,
  Divider,
} from 'react-native-paper';
import { useParking } from '../context/ParkingContext';

export default function ParkingEntryScreen({ navigation }) {
  const [licensePlate, setLicensePlate] = useState('');
  const [selectedVehicleType, setSelectedVehicleType] = useState('');
  const [notes, setNotes] = useState('');
  const [snackbarVisible, setSnackbarVisible] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState('');

  const { 
    vehicleTypes, 
    loading, 
    fetchVehicleTypes, 
    createParkingTransaction 
  } = useParking();

  useEffect(() => {
    console.log('ParkingEntryScreen: Component mounted');
    loadVehicleTypes();
  }, []);

  useEffect(() => {
    console.log('ParkingEntryScreen: Vehicle types updated:', vehicleTypes);
  }, [vehicleTypes]);

  const loadVehicleTypes = async () => {
    console.log('ParkingEntryScreen: Loading vehicle types...');
    await fetchVehicleTypes();
  };

  const handleSubmit = async () => {
    console.log('ParkingEntryScreen: Handle submit');
    console.log('License plate:', licensePlate);
    console.log('Selected vehicle type:', selectedVehicleType);
    
    if (!licensePlate.trim()) {
      showSnackbar('Silakan masukkan nomor plat');
      return;
    }

    if (!selectedVehicleType) {
      showSnackbar('Silakan pilih jenis kendaraan');
      return;
    }

    const selectedType = vehicleTypes.find(type => type.id.toString() === selectedVehicleType);
    console.log('Selected type object:', selectedType);
    
    if (!selectedType) {
      showSnackbar('Jenis kendaraan tidak valid');
      return;
    }

    Alert.alert(
      'Konfirmasi Transaksi',
      `Plat: ${licensePlate.toUpperCase()}\nJenis: ${selectedType.name}\nTarif: ${selectedType.formatted_rate}`,
      [
        { text: 'Batal', style: 'cancel' },
        { text: 'Simpan', onPress: submitTransaction },
      ]
    );
  };

  const submitTransaction = async () => {
    console.log('ParkingEntryScreen: Submit transaction');
    
    const transactionData = {
      license_plate: licensePlate.toUpperCase(),
      vehicle_type_id: parseInt(selectedVehicleType),
      entry_time: new Date().toISOString(),
      notes: notes.trim() || null,
    };
    
    console.log('Transaction data:', transactionData);

    const result = await createParkingTransaction(transactionData);
    console.log('Create transaction result:', result);
    
    if (result.success) {
      showSnackbar('Transaksi berhasil dibuat');
      
      // Reset form
      setLicensePlate('');
      setSelectedVehicleType('');
      setNotes('');
      
      // Show ticket details
      const data = result.data;
      Alert.alert(
        'Tiket Parkir',
        `Nomor Tiket: ${data.ticket_number}\nPlat: ${data.license_plate}\nJenis: ${data.vehicle_type?.name || 'Unknown'}\nTarif: ${data.formatted_amount}\nWaktu Masuk: ${data.formatted_entry_time}`,
        [
          { text: 'OK', onPress: () => navigation.navigate('Home') }
        ]
      );
    } else {
      showSnackbar(result.message || 'Gagal membuat transaksi');
    }
  };

  const showSnackbar = (message) => {
    setSnackbarMessage(message);
    setSnackbarVisible(true);
  };

  const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
    }).format(amount);
  };

  // Show loading state if no vehicle types loaded yet
  if (loading && vehicleTypes.length === 0) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" />
        <Text variant="bodyLarge" style={styles.loadingText}>
          Memuat jenis kendaraan...
        </Text>
      </View>
    );
  }

  // Show retry if failed to load vehicle types
  if (!loading && vehicleTypes.length === 0) {
    return (
      <View style={styles.loadingContainer}>
        <Text variant="bodyLarge" style={styles.loadingText}>
          Gagal memuat jenis kendaraan
        </Text>
        <Button mode="contained" onPress={loadVehicleTypes} style={styles.retryButton}>
          Coba Lagi
        </Button>
      </View>
    );
  }

  return (
    <ScrollView style={styles.container}>
      <Card style={styles.card}>
        <Card.Content>
          <Text variant="headlineSmall" style={styles.title}>
            Transaksi Parkir Baru
          </Text>
          
          <TextInput
            label="Nomor Plat Kendaraan"
            value={licensePlate}
            onChangeText={setLicensePlate}
            style={styles.input}
            mode="outlined"
            placeholder="Contoh: B1234CD"
            autoCapitalize="characters"
            autoCorrect={false}
          />

          <View style={styles.vehicleTypeSection}>
            <Text variant="titleMedium" style={styles.sectionTitle}>
              Pilih Jenis Kendaraan
            </Text>
            <Text variant="bodyMedium" style={styles.sectionSubtitle}>
              {vehicleTypes.length} jenis kendaraan tersedia
            </Text>
            
            <RadioButton.Group
              onValueChange={setSelectedVehicleType}
              value={selectedVehicleType}
            >
              {vehicleTypes.map((type) => (
                <View key={type.id} style={styles.radioItem}>
                  <View style={styles.radioContent}>
                    <View style={styles.vehicleInfo}>
                      <Text variant="bodyLarge" style={styles.vehicleTypeName}>
                        {type.name}
                      </Text>
                      <Text variant="bodyMedium" style={styles.vehicleTypeRate}>
                        {type.formatted_rate || formatCurrency(type.rate)}
                      </Text>
                    </View>
                    <RadioButton value={type.id.toString()} />
                  </View>
                </View>
              ))}
            </RadioButton.Group>
          </View>

          <TextInput
            label="Catatan (Opsional)"
            value={notes}
            onChangeText={setNotes}
            style={styles.input}
            mode="outlined"
            multiline
            numberOfLines={3}
            placeholder="Catatan tambahan..."
          />

          <Divider style={styles.divider} />

          {selectedVehicleType && (
            <View style={styles.summary}>
              <Text variant="titleMedium" style={styles.summaryTitle}>
                Ringkasan
              </Text>
              <View style={styles.summaryRow}>
                <Text variant="bodyMedium">Plat Kendaraan:</Text>
                <Text variant="bodyMedium" style={styles.summaryValue}>
                  {licensePlate.toUpperCase() || '-'}
                </Text>
              </View>
              <View style={styles.summaryRow}>
                <Text variant="bodyMedium">Jenis Kendaraan:</Text>
                <Text variant="bodyMedium" style={styles.summaryValue}>
                  {vehicleTypes.find(type => type.id.toString() === selectedVehicleType)?.name || '-'}
                </Text>
              </View>
              <View style={styles.summaryRow}>
                <Text variant="bodyMedium">Tarif Parkir:</Text>
                <Text variant="bodyMedium" style={[styles.summaryValue, styles.priceText]}>
                  {(() => {
                    const type = vehicleTypes.find(type => type.id.toString() === selectedVehicleType);
                    return type?.formatted_rate || formatCurrency(type?.rate || 0);
                  })()}
                </Text>
              </View>
            </View>
          )}

          <Button
            mode="contained"
            onPress={handleSubmit}
            style={styles.submitButton}
            disabled={loading || !licensePlate.trim() || !selectedVehicleType}
            icon="content-save"
            loading={loading}
          >
            Simpan Transaksi
          </Button>
        </Card.Content>
      </Card>

      <Snackbar
        visible={snackbarVisible}
        onDismiss={() => setSnackbarVisible(false)}
        duration={3000}
      >
        {snackbarMessage}
      </Snackbar>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
    padding: 16,
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 32,
  },
  loadingText: {
    marginTop: 16,
    textAlign: 'center',
  },
  retryButton: {
    marginTop: 16,
  },
  card: {
    elevation: 2,
  },
  title: {
    fontWeight: 'bold',
    marginBottom: 16,
    textAlign: 'center',
    color: '#1976d2',
  },
  input: {
    marginBottom: 16,
  },
  vehicleTypeSection: {
    marginBottom: 16,
  },
  sectionTitle: {
    fontWeight: 'bold',
    marginBottom: 4,
    color: '#333',
  },
  sectionSubtitle: {
    color: '#666',
    marginBottom: 12,
  },
  radioItem: {
    marginBottom: 8,
  },
  radioContent: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 12,
    paddingHorizontal: 16,
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#e9ecef',
  },
  vehicleInfo: {
    flex: 1,
  },
  vehicleTypeName: {
    fontWeight: '500',
    marginBottom: 2,
  },
  vehicleTypeRate: {
    color: '#2e7d32',
    fontWeight: 'bold',
  },
  divider: {
    marginVertical: 16,
  },
  summary: {
    backgroundColor: '#f8f9fa',
    padding: 16,
    borderRadius: 8,
    marginBottom: 16,
  },
  summaryTitle: {
    fontWeight: 'bold',
    marginBottom: 12,
  },
  summaryRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 6,
  },
  summaryValue: {
    fontWeight: '500',
    textAlign: 'right',
  },
  priceText: {
    color: '#2e7d32',
    fontWeight: 'bold',
  },
  submitButton: {
    paddingVertical: 8,
    marginTop: 8,
  },
});
