import React, { useState, useEffect } from 'react';
import {
  View,
  StyleSheet,
  ScrollView,
  Alert,
} from 'react-native';
import {
  TextInput,
  Button,
  Card,
  Title,
  Paragraph,
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

  const { vehicleTypes, loading, fetchVehicleTypes, createParkingTransaction } = useParking();

  useEffect(() => {
    if (vehicleTypes.length === 0) {
      fetchVehicleTypes();
    }
  }, []);

  const handleSubmit = async () => {
    if (!licensePlate.trim()) {
      showSnackbar('Silakan masukkan nomor plat');
      return;
    }

    if (!selectedVehicleType) {
      showSnackbar('Silakan pilih jenis kendaraan');
      return;
    }

    const selectedType = vehicleTypes.find(type => type.id.toString() === selectedVehicleType);
    
    Alert.alert(
      'Konfirmasi Transaksi',
      `Plat: ${licensePlate.toUpperCase()}\nJenis: ${selectedType?.name}\nTarif: ${selectedType?.formatted_rate}`,
      [
        { text: 'Batal', style: 'cancel' },
        { text: 'Simpan', onPress: submitTransaction },
      ]
    );
  };

  const submitTransaction = async () => {
    const transactionData = {
      license_plate: licensePlate.toUpperCase(),
      vehicle_type_id: parseInt(selectedVehicleType),
      entry_time: new Date().toISOString(),
      notes: notes.trim() || null,
    };

    const result = await createParkingTransaction(transactionData);
    
    if (result.success) {
      showSnackbar('Transaksi berhasil dibuat');
      // Reset form
      setLicensePlate('');
      setSelectedVehicleType('');
      setNotes('');
      
      // Show ticket details
      Alert.alert(
        'Tiket Parkir',
        `Nomor Tiket: ${result.data.ticket_number}\nPlat: ${result.data.license_plate}\nJenis: ${result.data.vehicle_type.name}\nTarif: ${result.data.formatted_amount}\nWaktu Masuk: ${result.data.formatted_entry_time}`,
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
    }).format(amount);
  };

  if (loading && vehicleTypes.length === 0) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" />
        <Paragraph style={styles.loadingText}>
          Memuat data jenis kendaraan...
        </Paragraph>
      </View>
    );
  }

  return (
    <ScrollView style={styles.container}>
      <Card style={styles.card}>
        <Card.Content>
          <Title style={styles.title}>Transaksi Parkir Baru</Title>
          
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
            <Paragraph style={styles.sectionTitle}>
              Pilih Jenis Kendaraan
            </Paragraph>
            <RadioButton.Group
              onValueChange={setSelectedVehicleType}
              value={selectedVehicleType}
            >
              {vehicleTypes.map((type) => (
                <View key={type.id} style={styles.radioItem}>
                  <View style={styles.radioContent}>
                    <View>
                      <Paragraph style={styles.vehicleTypeName}>
                        {type.name}
                      </Paragraph>
                      <Paragraph style={styles.vehicleTypeRate}>
                        {formatCurrency(type.flat_rate)}
                      </Paragraph>
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
              <Title style={styles.summaryTitle}>Ringkasan</Title>
              <View style={styles.summaryRow}>
                <Paragraph>Plat Kendaraan:</Paragraph>
                <Paragraph style={styles.summaryValue}>
                  {licensePlate.toUpperCase() || '-'}
                </Paragraph>
              </View>
              <View style={styles.summaryRow}>
                <Paragraph>Jenis Kendaraan:</Paragraph>
                <Paragraph style={styles.summaryValue}>
                  {vehicleTypes.find(type => type.id.toString() === selectedVehicleType)?.name || '-'}
                </Paragraph>
              </View>
              <View style={styles.summaryRow}>
                <Paragraph>Tarif Parkir:</Paragraph>
                <Paragraph style={[styles.summaryValue, styles.priceText]}>
                  {vehicleTypes.find(type => type.id.toString() === selectedVehicleType)?.formatted_rate || '-'}
                </Paragraph>
              </View>
            </View>
          )}

          <Button
            mode="contained"
            onPress={handleSubmit}
            style={styles.submitButton}
            disabled={loading || !licensePlate.trim() || !selectedVehicleType}
            icon="content-save"
          >
            {loading ? <ActivityIndicator color="white" /> : 'Simpan Transaksi'}
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
  },
  loadingText: {
    marginTop: 16,
    textAlign: 'center',
  },
  card: {
    elevation: 2,
  },
  title: {
    fontSize: 20,
    fontWeight: 'bold',
    marginBottom: 16,
    textAlign: 'center',
    color: '#007bff',
  },
  input: {
    marginBottom: 16,
  },
  vehicleTypeSection: {
    marginBottom: 16,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 8,
    color: '#333',
  },
  radioItem: {
    marginBottom: 8,
  },
  radioContent: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 8,
    paddingHorizontal: 12,
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#e9ecef',
  },
  vehicleTypeName: {
    fontSize: 16,
    fontWeight: '500',
  },
  vehicleTypeRate: {
    fontSize: 14,
    color: '#28a745',
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
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 8,
  },
  summaryRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 4,
  },
  summaryValue: {
    fontWeight: '500',
  },
  priceText: {
    color: '#28a745',
    fontWeight: 'bold',
  },
  submitButton: {
    paddingVertical: 8,
    marginTop: 8,
  },
});
