// screens/ParkingEntryScreen.js - Unified version with Web compatibility
import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  ScrollView,
  StyleSheet,
  Alert,
  KeyboardAvoidingView,
  Platform
} from 'react-native';
import { Card, Button, Chip } from 'react-native-paper';
import { useParkingContext } from '../context/ParkingContext';

const ParkingEntryScreen = ({ navigation }) => {
  const {
    vehicleTypes,
    createParkingTransaction,
    loading,
    error,
    clearError
  } = useParkingContext();

  const [formData, setFormData] = useState({
    vehicle_type_id: null,
    license_plate: '',
    notes: ''
  });

  const [selectedVehicleType, setSelectedVehicleType] = useState(null);

  useEffect(() => {
    if (error) {
      Alert.alert('Error', error);
      clearError();
    }
  }, [error, clearError]);

  const handleVehicleTypeSelect = (vehicleType) => {
    console.log('Selected vehicle type:', vehicleType);
    setSelectedVehicleType(vehicleType);
    setFormData(prev => ({
      ...prev,
      vehicle_type_id: vehicleType.id
    }));
  };

  const formatLicensePlate = (text) => {
    // Remove any non-alphanumeric characters and convert to uppercase
    const cleaned = text.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
    
    if (cleaned.length === 0) return '';
    
    // Format Indonesian license plate patterns
    if (cleaned.length <= 2) {
      return cleaned;
    } else if (cleaned.length <= 6) {
      return `${cleaned.slice(0, 2)} ${cleaned.slice(2)}`;
    } else {
      return `${cleaned.slice(0, 2)} ${cleaned.slice(2, 6)} ${cleaned.slice(6, 8)}`;
    }
  };

  const handleLicensePlateChange = (text) => {
    const formatted = formatLicensePlate(text);
    setFormData(prev => ({
      ...prev,
      license_plate: formatted
    }));
  };

  const handleSubmit = async () => {
    try {
      // Validation
      if (!formData.vehicle_type_id) {
        Alert.alert('Error', 'Pilih jenis kendaraan terlebih dahulu');
        return;
      }

      console.log('Submitting parking transaction:', formData);
      console.log('Selected vehicle type:', selectedVehicleType);

      const response = await createParkingTransaction(formData);
      
      if (response.success) {
        Alert.alert(
          'Success',
          `Transaksi parkir berhasil dibuat!\n\nTiket: ${response.data.ticket_number}\nJenis: ${selectedVehicleType?.name}\nTarif: ${selectedVehicleType?.formatted_rate}`,
          [
            {
              text: 'OK',
              onPress: () => {
                // Reset form
                setFormData({
                  vehicle_type_id: null,
                  license_plate: '',
                  notes: ''
                });
                setSelectedVehicleType(null);
                
                // Navigate back or to history
                navigation.navigate('History');
              }
            }
          ]
        );
      }
    } catch (error) {
      console.error('Submit error:', error);
      Alert.alert('Error', `Gagal membuat transaksi: ${error.message}`);
    }
  };

  const renderVehicleTypeCard = (vehicleType) => (
    <TouchableOpacity
      key={vehicleType.id}
      style={[
        styles.vehicleTypeCard,
        selectedVehicleType?.id === vehicleType.id && styles.selectedCard
      ]}
      onPress={() => handleVehicleTypeSelect(vehicleType)}
    >
      <Card style={styles.card}>
        <Card.Content style={styles.cardContent}>
          <Text style={styles.vehicleTypeName}>{vehicleType.name}</Text>
          <Text style={styles.vehicleTypeRate}>
            {vehicleType.formatted_rate || `Rp ${new Intl.NumberFormat('id-ID').format(vehicleType.rate || vehicleType.flat_rate)}`}
          </Text>
          {selectedVehicleType?.id === vehicleType.id && (
            <Chip mode="flat" style={styles.selectedChip}>
              Dipilih
            </Chip>
          )}
        </Card.Content>
      </Card>
    </TouchableOpacity>
  );

  return (
    <KeyboardAvoidingView 
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
      style={styles.container}
    >
      <ScrollView style={styles.scrollContainer} showsVerticalScrollIndicator={false}>
        <View style={styles.content}>
          <Text style={styles.title}>Kendaraan Masuk</Text>
          
          {/* Vehicle Type Selection */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Pilih Jenis Kendaraan</Text>
            <View style={styles.vehicleTypeGrid}>
              {vehicleTypes.map(renderVehicleTypeCard)}
            </View>
          </View>

          {/* Selected Vehicle Info */}
          {selectedVehicleType && (
            <View style={styles.section}>
              <Card style={styles.infoCard}>
                <Card.Content>
                  <Text style={styles.infoTitle}>Tarif yang Dipilih</Text>
                  <Text style={styles.infoVehicle}>{selectedVehicleType.name}</Text>
                  <Text style={styles.infoRate}>
                    {selectedVehicleType.formatted_rate || `Rp ${new Intl.NumberFormat('id-ID').format(selectedVehicleType.rate || selectedVehicleType.flat_rate)}`}
                  </Text>
                </Card.Content>
              </Card>
            </View>
          )}

          {/* License Plate */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Nomor Plat Kendaraan (Opsional)</Text>
            <TextInput
              style={styles.input}
              value={formData.license_plate}
              onChangeText={handleLicensePlateChange}
              placeholder="Contoh: B 1234 ABC"
              autoCapitalize="characters"
              maxLength={11}
            />
            <Text style={styles.helperText}>
              Format otomatis: B 1234 ABC
            </Text>
          </View>

          {/* Notes */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Catatan (Opsional)</Text>
            <TextInput
              style={[styles.input, styles.textArea]}
              value={formData.notes}
              onChangeText={(text) => setFormData(prev => ({ ...prev, notes: text }))}
              placeholder="Catatan tambahan"
              multiline
              numberOfLines={3}
            />
          </View>

          {/* Submit Button */}
          <View style={styles.submitSection}>
            <Button
              mode="contained"
              onPress={handleSubmit}
              loading={loading}
              disabled={!formData.vehicle_type_id || loading}
              style={styles.submitButton}
              labelStyle={styles.submitButtonLabel}
            >
              {loading ? 'Memproses...' : 'Proses Masuk'}
            </Button>
          </View>
        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  scrollContainer: {
    flex: 1,
  },
  content: {
    padding: 16,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    color: '#333',
    textAlign: 'center',
  },
  section: {
    marginBottom: 20,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: '600',
    marginBottom: 10,
    color: '#333',
  },
  vehicleTypeGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 10,
  },
  vehicleTypeCard: {
    width: '48%',
  },
  card: {
    backgroundColor: '#fff',
    elevation: 2,
    borderRadius: 8,
  },
  selectedCard: {
    borderWidth: 2,
    borderColor: '#6200ee',
  },
  cardContent: {
    alignItems: 'center',
    padding: 16,
  },
  vehicleTypeName: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 4,
    color: '#333',
  },
  vehicleTypeRate: {
    fontSize: 14,
    color: '#666',
    marginBottom: 8,
  },
  selectedChip: {
    backgroundColor: '#6200ee',
  },
  infoCard: {
    backgroundColor: '#e3f2fd',
    elevation: 1,
  },
  infoTitle: {
    fontSize: 14,
    color: '#666',
    marginBottom: 4,
  },
  infoVehicle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 4,
  },
  infoRate: {
    fontSize: 16,
    color: '#1976d2',
    fontWeight: '600',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 8,
    padding: 12,
    backgroundColor: '#fff',
    fontSize: 16,
  },
  textArea: {
    height: 80,
    textAlignVertical: 'top',
  },
  helperText: {
    fontSize: 12,
    color: '#666',
    marginTop: 4,
    fontStyle: 'italic',
  },
  submitSection: {
    marginTop: 20,
    marginBottom: 40,
  },
  submitButton: {
    paddingVertical: 8,
    backgroundColor: '#6200ee',
  },
  submitButtonLabel: {
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default ParkingEntryScreen;
