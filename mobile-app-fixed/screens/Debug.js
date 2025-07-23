// Debug.js - Debug helper untuk testing di Expo Snack
import React, { useState } from 'react';
import { View, ScrollView, StyleSheet } from 'react-native';
import { Text, Button, Card } from 'react-native-paper';
import ApiService from '../services/ApiService';

const Debug = () => {
  const [logs, setLogs] = useState([]);

  const addLog = (message) => {
    const timestamp = new Date().toLocaleTimeString();
    setLogs(prev => [...prev, `${timestamp}: ${message}`]);
    console.log(message);
  };

  const clearLogs = () => {
    setLogs([]);
  };

  const testHealth = async () => {
    try {
      addLog('Testing health endpoint...');
      const response = await ApiService.healthCheck();
      addLog('✅ Health check passed: ' + JSON.stringify(response));
    } catch (error) {
      addLog('❌ Health check failed: ' + error.message);
    }
  };

  const testLogin = async () => {
    try {
      addLog('Testing login...');
      const response = await ApiService.login('admin@parkir.com', 'password');
      addLog('✅ Login successful: ' + JSON.stringify(response));
    } catch (error) {
      addLog('❌ Login failed: ' + error.message);
    }
  };

  const testVehicleTypes = async () => {
    try {
      addLog('Testing vehicle types...');
      const response = await ApiService.getVehicleTypes();
      addLog('✅ Vehicle types loaded:');
      addLog(JSON.stringify(response, null, 2));
    } catch (error) {
      addLog('❌ Vehicle types failed: ' + error.message);
    }
  };

  const testCreateParking = async () => {
    try {
      addLog('Testing create parking...');
      const transactionData = {
        license_plate: 'TEST123',
        vehicle_type_id: 1,
        entry_time: new Date().toISOString(),
        notes: 'Debug test transaction',
      };
      
      const response = await ApiService.createParking(transactionData);
      addLog('✅ Parking created:');
      addLog(JSON.stringify(response, null, 2));
    } catch (error) {
      addLog('❌ Create parking failed: ' + error.message);
    }
  };

  const testParkingHistory = async () => {
    try {
      addLog('Testing parking history...');
      const response = await ApiService.getParkingHistory(1);
      addLog('✅ Parking history loaded:');
      addLog(`Total: ${response.pagination?.total || 0} items`);
      if (response.data && response.data.length > 0) {
        addLog('Sample item:');
        addLog(JSON.stringify(response.data[0], null, 2));
      }
    } catch (error) {
      addLog('❌ Parking history failed: ' + error.message);
    }
  };

  const runAllTests = async () => {
    clearLogs();
    addLog('🚀 Starting API tests...');
    
    await testHealth();
    await testVehicleTypes();
    await testLogin();
    await testCreateParking();
    await testParkingHistory();
    
    addLog('✅ All tests completed!');
  };

  return (
    <ScrollView style={styles.container}>
      <Card style={styles.card}>
        <Card.Content>
          <Text variant="headlineSmall" style={styles.title}>
            API Debug Console
          </Text>
          
          <Text variant="bodyMedium" style={styles.subtitle}>
            Test your API connection and responses
          </Text>
          
          <View style={styles.buttonContainer}>
            <Button mode="contained" onPress={runAllTests} style={styles.button}>
              Run All Tests
            </Button>
            
            <Button mode="outlined" onPress={testHealth} style={styles.button}>
              Test Health
            </Button>
            
            <Button mode="outlined" onPress={testVehicleTypes} style={styles.button}>
              Test Vehicle Types
            </Button>
            
            <Button mode="outlined" onPress={testLogin} style={styles.button}>
              Test Login
            </Button>
            
            <Button mode="outlined" onPress={testCreateParking} style={styles.button}>
              Test Create Parking
            </Button>
            
            <Button mode="outlined" onPress={testParkingHistory} style={styles.button}>
              Test History
            </Button>
            
            <Button mode="text" onPress={clearLogs} style={styles.button}>
              Clear Logs
            </Button>
          </View>
        </Card.Content>
      </Card>

      <Card style={styles.card}>
        <Card.Content>
          <Text variant="titleMedium" style={styles.logTitle}>
            Console Logs ({logs.length})
          </Text>
          
          <ScrollView style={styles.logContainer}>
            {logs.map((log, index) => (
              <Text key={index} variant="bodySmall" style={styles.logText}>
                {log}
              </Text>
            ))}
            
            {logs.length === 0 && (
              <Text variant="bodyMedium" style={styles.emptyLog}>
                No logs yet. Run tests to see results.
              </Text>
            )}
          </ScrollView>
        </Card.Content>
      </Card>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
    padding: 16,
  },
  card: {
    marginBottom: 16,
    elevation: 2,
  },
  title: {
    fontWeight: 'bold',
    marginBottom: 8,
    textAlign: 'center',
    color: '#1976d2',
  },
  subtitle: {
    textAlign: 'center',
    marginBottom: 16,
    color: '#666',
  },
  buttonContainer: {
    gap: 8,
  },
  button: {
    marginBottom: 8,
  },
  logTitle: {
    fontWeight: 'bold',
    marginBottom: 12,
  },
  logContainer: {
    maxHeight: 300,
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
    padding: 12,
  },
  logText: {
    fontFamily: 'monospace',
    marginBottom: 4,
    color: '#333',
  },
  emptyLog: {
    textAlign: 'center',
    color: '#666',
    fontStyle: 'italic',
  },
});

export default Debug;
