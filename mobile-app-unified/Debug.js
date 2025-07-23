// Debug.js - Testing and debugging utilities for unified mobile app
import React, { useState } from 'react';
import { View, Text, ScrollView, StyleSheet, Alert } from 'react-native';
import { Button, Card } from 'react-native-paper';
import ApiService from '../services/ApiService';

const Debug = () => {
  const [testResults, setTestResults] = useState({});
  const [loading, setLoading] = useState(false);

  const addTestResult = (testName, success, data, error = null) => {
    setTestResults(prev => ({
      ...prev,
      [testName]: {
        success,
        data,
        error,
        timestamp: new Date().toLocaleTimeString()
      }
    }));
  };

  const testHealthCheck = async () => {
    setLoading(true);
    try {
      const response = await ApiService.checkHealth();
      addTestResult('Health Check', true, response);
    } catch (error) {
      addTestResult('Health Check', false, null, error.message);
    }
    setLoading(false);
  };

  const testVehicleTypes = async () => {
    setLoading(true);
    try {
      const response = await ApiService.getVehicleTypes();
      addTestResult('Vehicle Types', response.success, response.data, response.success ? null : response.message);
    } catch (error) {
      addTestResult('Vehicle Types', false, null, error.message);
    }
    setLoading(false);
  };

  const testDemoVehicleTypes = async () => {
    setLoading(true);
    try {
      const response = await ApiService.getDemoVehicleTypes();
      addTestResult('Demo Vehicle Types', response.success, response.data, response.success ? null : response.message);
    } catch (error) {
      addTestResult('Demo Vehicle Types', false, null, error.message);
    }
    setLoading(false);
  };

  const testParkingHistory = async () => {
    setLoading(true);
    try {
      const response = await ApiService.getParkingHistory(1);
      addTestResult('Parking History', response.success, response.data?.slice(0, 2), response.success ? null : response.message);
    } catch (error) {
      addTestResult('Parking History', false, null, error.message);
    }
    setLoading(false);
  };

  const testDemoTransaction = async () => {
    setLoading(true);
    try {
      const demoData = {
        vehicle_type_id: 1,
        license_plate: 'B 1234 TEST',
        notes: 'Demo transaction from mobile app'
      };
      const response = await ApiService.createDemoParkingTransaction(demoData);
      addTestResult('Demo Transaction', response.success, response.data, response.success ? null : response.message);
    } catch (error) {
      addTestResult('Demo Transaction', false, null, error.message);
    }
    setLoading(false);
  };

  const testUnifiedFormat = async () => {
    setLoading(true);
    try {
      // Test vehicle types format
      const vehicleResponse = await ApiService.getVehicleTypes();
      if (vehicleResponse.success && vehicleResponse.data.length > 0) {
        const firstVehicle = vehicleResponse.data[0];
        const hasUnifiedFormat = firstVehicle.hasOwnProperty('rate') && firstVehicle.hasOwnProperty('flat_rate');
        
        addTestResult('Unified Format Test', hasUnifiedFormat, {
          vehicle_sample: firstVehicle,
          has_rate: firstVehicle.hasOwnProperty('rate'),
          has_flat_rate: firstVehicle.hasOwnProperty('flat_rate'),
          rate_value: firstVehicle.rate,
          flat_rate_value: firstVehicle.flat_rate,
          values_match: firstVehicle.rate === firstVehicle.flat_rate
        }, hasUnifiedFormat ? null : 'Vehicle type missing unified format fields');
      } else {
        addTestResult('Unified Format Test', false, null, 'No vehicle types data');
      }
    } catch (error) {
      addTestResult('Unified Format Test', false, null, error.message);
    }
    setLoading(false);
  };

  const runAllTests = async () => {
    setTestResults({});
    await testHealthCheck();
    await testDemoVehicleTypes();
    await testVehicleTypes();
    await testParkingHistory();
    await testDemoTransaction();
    await testUnifiedFormat();
    
    Alert.alert('Tests Complete', 'All API tests have been completed. Check results below.');
  };

  const clearResults = () => {
    setTestResults({});
  };

  const renderTestResult = (testName, result) => {
    if (!result) return null;

    return (
      <Card key={testName} style={[styles.resultCard, result.success ? styles.successCard : styles.errorCard]}>
        <Card.Content>
          <Text style={styles.testName}>{testName}</Text>
          <Text style={styles.timestamp}>{result.timestamp}</Text>
          <Text style={[styles.status, result.success ? styles.successText : styles.errorText]}>
            {result.success ? '✅ SUCCESS' : '❌ FAILED'}
          </Text>
          
          {result.error && (
            <View style={styles.errorSection}>
              <Text style={styles.errorLabel}>Error:</Text>
              <Text style={styles.errorText}>{result.error}</Text>
            </View>
          )}
          
          {result.data && (
            <View style={styles.dataSection}>
              <Text style={styles.dataLabel}>Data:</Text>
              <Text style={styles.dataText}>{JSON.stringify(result.data, null, 2)}</Text>
            </View>
          )}
        </Card.Content>
      </Card>
    );
  };

  return (
    <View style={styles.container}>
      <ScrollView style={styles.scrollView} showsVerticalScrollIndicator={false}>
        <View style={styles.content}>
          <Text style={styles.title}>API Debug & Testing</Text>
          <Text style={styles.subtitle}>Test koneksi dan format data unified mobile app</Text>

          {/* Control Buttons */}
          <View style={styles.buttonSection}>
            <Button
              mode="contained"
              onPress={runAllTests}
              loading={loading}
              disabled={loading}
              style={styles.primaryButton}
            >
              Run All Tests
            </Button>
            
            <View style={styles.buttonRow}>
              <Button
                mode="outlined"
                onPress={testHealthCheck}
                disabled={loading}
                style={styles.secondaryButton}
              >
                Health Check
              </Button>
              
              <Button
                mode="outlined"
                onPress={testDemoVehicleTypes}
                disabled={loading}
                style={styles.secondaryButton}
              >
                Demo Vehicle Types
              </Button>
            </View>
            
            <View style={styles.buttonRow}>
              <Button
                mode="outlined"
                onPress={testVehicleTypes}
                disabled={loading}
                style={styles.secondaryButton}
              >
                Auth Vehicle Types
              </Button>
              
              <Button
                mode="outlined"
                onPress={testParkingHistory}
                disabled={loading}
                style={styles.secondaryButton}
              >
                Parking History
              </Button>
            </View>
            
            <View style={styles.buttonRow}>
              <Button
                mode="outlined"
                onPress={testDemoTransaction}
                disabled={loading}
                style={styles.secondaryButton}
              >
                Demo Transaction
              </Button>
              
              <Button
                mode="outlined"
                onPress={testUnifiedFormat}
                disabled={loading}
                style={styles.secondaryButton}
              >
                Format Test
              </Button>
            </View>
            
            <Button
              mode="text"
              onPress={clearResults}
              disabled={loading}
              style={styles.clearButton}
            >
              Clear Results
            </Button>
          </View>

          {/* Test Results */}
          <View style={styles.resultsSection}>
            <Text style={styles.resultsTitle}>Test Results</Text>
            {Object.keys(testResults).length === 0 ? (
              <Text style={styles.noResults}>No test results yet</Text>
            ) : (
              Object.entries(testResults).map(([testName, result]) =>
                renderTestResult(testName, result)
              )
            )}
          </View>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  scrollView: {
    flex: 1,
  },
  content: {
    padding: 16,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    textAlign: 'center',
    marginBottom: 4,
    color: '#333',
  },
  subtitle: {
    fontSize: 14,
    textAlign: 'center',
    color: '#666',
    marginBottom: 24,
  },
  buttonSection: {
    marginBottom: 24,
  },
  primaryButton: {
    marginBottom: 16,
    backgroundColor: '#6200ee',
  },
  buttonRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 12,
    gap: 8,
  },
  secondaryButton: {
    flex: 1,
  },
  clearButton: {
    marginTop: 8,
  },
  resultsSection: {
    marginBottom: 40,
  },
  resultsTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 16,
    color: '#333',
  },
  noResults: {
    textAlign: 'center',
    color: '#666',
    fontStyle: 'italic',
    padding: 20,
  },
  resultCard: {
    marginBottom: 12,
  },
  successCard: {
    borderLeftWidth: 4,
    borderLeftColor: '#4caf50',
  },
  errorCard: {
    borderLeftWidth: 4,
    borderLeftColor: '#f44336',
  },
  testName: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 4,
    color: '#333',
  },
  timestamp: {
    fontSize: 12,
    color: '#666',
    marginBottom: 8,
  },
  status: {
    fontSize: 14,
    fontWeight: 'bold',
    marginBottom: 8,
  },
  successText: {
    color: '#4caf50',
  },
  errorText: {
    color: '#f44336',
  },
  errorSection: {
    marginTop: 8,
    padding: 8,
    backgroundColor: '#ffebee',
    borderRadius: 4,
  },
  errorLabel: {
    fontSize: 12,
    fontWeight: 'bold',
    color: '#d32f2f',
    marginBottom: 4,
  },
  dataSection: {
    marginTop: 8,
    padding: 8,
    backgroundColor: '#f0f0f0',
    borderRadius: 4,
  },
  dataLabel: {
    fontSize: 12,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 4,
  },
  dataText: {
    fontSize: 11,
    fontFamily: 'monospace',
    color: '#333',
    lineHeight: 16,
  },
});

export default Debug;
