import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  TextInput,
  ScrollView,
  Alert,
  Modal,
  ActivityIndicator,
} from 'react-native';
import { useApp } from '../contexts/AppContext';

const TransactionScreen = ({ hideHeader = false }) => {
  const { vehicleTypes, createTransaction, isAuthenticated } = useApp();
  const [selectedVehicleType, setSelectedVehicleType] = useState(null);
  const [licensePlate, setLicensePlate] = useState('');
  const [notes, setNotes] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [showTicket, setShowTicket] = useState(false);
  const [ticketData, setTicketData] = useState(null);

  const handleCreateTransaction = async () => {
    if (!selectedVehicleType) {
      Alert.alert('Error', 'Pilih jenis kendaraan terlebih dahulu');
      return;
    }

    setIsLoading(true);

    try {
      const transactionData = {
        vehicle_type_id: selectedVehicleType.id,
        license_plate: licensePlate.trim() || null,
        notes: notes.trim() || null,
      };

      const response = await createTransaction(transactionData);

      if (response.success) {
        setTicketData(response.data);
        setShowTicket(true);
        
        // Reset form
        setSelectedVehicleType(null);
        setLicensePlate('');
        setNotes('');
      } else {
        Alert.alert('Error', response.message || 'Gagal membuat transaksi');
      }
    } catch (error) {
      Alert.alert('Error', `Gagal membuat transaksi: ${error.message}`);
    } finally {
      setIsLoading(false);
    }
  };

  const formatCurrency = (amount) => {
    return `Rp ${amount?.toLocaleString('id-ID') || '0'}`;
  };

  const formatLicensePlate = (text) => {
    // Format plat nomor Indonesia
    return text.toUpperCase().replace(/[^A-Z0-9]/g, '');
  };

  const VehicleTypeCard = ({ vehicleType, isSelected, onSelect }) => (
    <TouchableOpacity
      style={[
        styles.vehicleCard,
        isSelected && styles.vehicleCardSelected
      ]}
      onPress={() => onSelect(vehicleType)}
    >
      <Text style={[
        styles.vehicleName,
        isSelected && styles.vehicleNameSelected
      ]}>
        {vehicleType.name}
      </Text>
      <Text style={[
        styles.vehiclePrice,
        isSelected && styles.vehiclePriceSelected
      ]}>
        {formatCurrency(vehicleType.flat_rate || vehicleType.rate)}
      </Text>
    </TouchableOpacity>
  );

  const TicketModal = () => (
    <Modal
      visible={showTicket}
      animationType="slide"
      transparent={true}
    >
      <View style={styles.modalOverlay}>
        <View style={styles.ticketModal}>
          <Text style={styles.ticketTitle}>TIKET PARKIR</Text>
          
          {ticketData && (
            <View style={styles.ticketContent}>
              <View style={styles.ticketRow}>
                <Text style={styles.ticketLabel}>Nomor Tiket:</Text>
                <Text style={styles.ticketValue}>{ticketData.ticket_number}</Text>
              </View>
              
              <View style={styles.ticketRow}>
                <Text style={styles.ticketLabel}>Jenis Kendaraan:</Text>
                <Text style={styles.ticketValue}>{ticketData.vehicle_type?.name}</Text>
              </View>
              
              {ticketData.license_plate && (
                <View style={styles.ticketRow}>
                  <Text style={styles.ticketLabel}>Plat Nomor:</Text>
                  <Text style={styles.ticketValue}>{ticketData.license_plate}</Text>
                </View>
              )}
              
              <View style={styles.ticketRow}>
                <Text style={styles.ticketLabel}>Tarif:</Text>
                <Text style={styles.ticketValue}>{ticketData.formatted_amount}</Text>
              </View>
              
              <View style={styles.ticketRow}>
                <Text style={styles.ticketLabel}>Waktu Masuk:</Text>
                <Text style={styles.ticketValue}>{ticketData.formatted_entry_time}</Text>
              </View>
              
              {ticketData.notes && (
                <View style={styles.ticketRow}>
                  <Text style={styles.ticketLabel}>Catatan:</Text>
                  <Text style={styles.ticketValue}>{ticketData.notes}</Text>
                </View>
              )}
            </View>
          )}
          
          <TouchableOpacity
            style={styles.closeButton}
            onPress={() => setShowTicket(false)}
          >
            <Text style={styles.closeButtonText}>TUTUP</Text>
          </TouchableOpacity>
        </View>
      </View>
    </Modal>
  );

  return (
    <ScrollView style={styles.container}>
      {!hideHeader && (
        <View style={styles.header}>
          <Text style={styles.title}>Transaksi Parkir</Text>
          {!isAuthenticated && (
            <Text style={styles.demoText}>Mode Demo</Text>
          )}
        </View>
      )}

      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Pilih Jenis Kendaraan</Text>
        <View style={styles.vehicleGrid}>
          {vehicleTypes.map((vehicleType) => (
            <VehicleTypeCard
              key={vehicleType.id}
              vehicleType={vehicleType}
              isSelected={selectedVehicleType?.id === vehicleType.id}
              onSelect={setSelectedVehicleType}
            />
          ))}
        </View>
      </View>

      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Plat Nomor (Opsional)</Text>
        <TextInput
          style={styles.input}
          placeholder="Contoh: B1234XYZ"
          value={licensePlate}
          onChangeText={(text) => setLicensePlate(formatLicensePlate(text))}
          maxLength={15}
          autoCapitalize="characters"
        />
      </View>

      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Catatan (Opsional)</Text>
        <TextInput
          style={[styles.input, styles.notesInput]}
          placeholder="Masukkan catatan..."
          value={notes}
          onChangeText={setNotes}
          maxLength={500}
          multiline
          numberOfLines={3}
        />
      </View>

      {selectedVehicleType && (
        <View style={styles.summarySection}>
          <View style={styles.summaryRow}>
            <Text style={styles.summaryLabel}>Jenis Kendaraan:</Text>
            <Text style={styles.summaryValue}>{selectedVehicleType.name}</Text>
          </View>
          <View style={styles.summaryRow}>
            <Text style={styles.summaryLabel}>Tarif:</Text>
            <Text style={styles.summaryValue}>
              {formatCurrency(selectedVehicleType.flat_rate || selectedVehicleType.rate)}
            </Text>
          </View>
        </View>
      )}

      <TouchableOpacity
        style={[
          styles.createButton,
          (!selectedVehicleType || isLoading) && styles.createButtonDisabled
        ]}
        onPress={handleCreateTransaction}
        disabled={!selectedVehicleType || isLoading}
      >
        {isLoading ? (
          <ActivityIndicator color="#fff" />
        ) : (
          <Text style={styles.createButtonText}>BUAT TRANSAKSI</Text>
        )}
      </TouchableOpacity>

      <TicketModal />
    </ScrollView>
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
  demoText: {
    fontSize: 14,
    color: '#fff',
    textAlign: 'center',
    marginTop: 5,
    opacity: 0.8,
  },
  section: {
    backgroundColor: '#fff',
    margin: 16,
    padding: 16,
    borderRadius: 8,
    elevation: 2,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 12,
    color: '#333',
  },
  vehicleGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between',
  },
  vehicleCard: {
    backgroundColor: '#f8f9fa',
    padding: 16,
    borderRadius: 8,
    borderWidth: 2,
    borderColor: '#e9ecef',
    marginBottom: 8,
    minWidth: '30%',
    alignItems: 'center',
  },
  vehicleCardSelected: {
    backgroundColor: '#2196F3',
    borderColor: '#1976D2',
  },
  vehicleName: {
    fontSize: 14,
    fontWeight: 'bold',
    color: '#333',
  },
  vehicleNameSelected: {
    color: '#fff',
  },
  vehiclePrice: {
    fontSize: 12,
    color: '#666',
    marginTop: 4,
  },
  vehiclePriceSelected: {
    color: '#fff',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 6,
    padding: 12,
    fontSize: 16,
    backgroundColor: '#fff',
  },
  notesInput: {
    height: 80,
    textAlignVertical: 'top',
  },
  summarySection: {
    backgroundColor: '#fff',
    margin: 16,
    padding: 16,
    borderRadius: 8,
    elevation: 2,
    borderTopWidth: 3,
    borderTopColor: '#4CAF50',
  },
  summaryRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  summaryLabel: {
    fontSize: 14,
    color: '#666',
  },
  summaryValue: {
    fontSize: 14,
    fontWeight: 'bold',
    color: '#333',
  },
  createButton: {
    backgroundColor: '#4CAF50',
    margin: 16,
    padding: 16,
    borderRadius: 8,
    alignItems: 'center',
  },
  createButtonDisabled: {
    backgroundColor: '#ccc',
  },
  createButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
  
  // Modal styles
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.5)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  ticketModal: {
    backgroundColor: '#fff',
    margin: 20,
    padding: 20,
    borderRadius: 8,
    maxWidth: 350,
    width: '90%',
  },
  ticketTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    textAlign: 'center',
    marginBottom: 20,
    color: '#333',
  },
  ticketContent: {
    marginBottom: 20,
  },
  ticketRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 12,
    paddingBottom: 8,
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
  },
  ticketLabel: {
    fontSize: 14,
    color: '#666',
    flex: 1,
  },
  ticketValue: {
    fontSize: 14,
    fontWeight: 'bold',
    color: '#333',
    flex: 1,
    textAlign: 'right',
  },
  closeButton: {
    backgroundColor: '#2196F3',
    padding: 12,
    borderRadius: 6,
    alignItems: 'center',
  },
  closeButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default TransactionScreen;
