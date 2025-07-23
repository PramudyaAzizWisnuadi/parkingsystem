import React, { useState } from 'react';
import {
  View,
  StyleSheet,
  Alert,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
} from 'react-native';
import {
  TextInput,
  Button,
  Card,
  Title,
  Paragraph,
  ActivityIndicator,
  Snackbar,
} from 'react-native-paper';
import { useAuth } from '../context/AuthContext';

export default function LoginScreen() {
  const [email, setEmail] = useState('admin@parkir.com');
  const [password, setPassword] = useState('password');
  const [isRegister, setIsRegister] = useState(false);
  const [name, setName] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [snackbarVisible, setSnackbarVisible] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState('');

  const { login, register, loading } = useAuth();

  const handleLogin = async () => {
    if (!email || !password) {
      showSnackbar('Silakan isi email dan password');
      return;
    }

    const result = await login(email, password);
    if (!result.success) {
      showSnackbar(result.message);
    }
  };

  const handleRegister = async () => {
    if (!name || !email || !password || !confirmPassword) {
      showSnackbar('Silakan isi semua field');
      return;
    }

    if (password !== confirmPassword) {
      showSnackbar('Password dan konfirmasi password tidak sama');
      return;
    }

    const result = await register(name, email, password, confirmPassword);
    if (!result.success) {
      showSnackbar(result.message);
    }
  };

  const showSnackbar = (message) => {
    setSnackbarMessage(message);
    setSnackbarVisible(true);
  };

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
    >
      <ScrollView contentContainerStyle={styles.scrollContainer}>
        <Card style={styles.card}>
          <Card.Content>
            <Title style={styles.title}>
              {isRegister ? 'Daftar' : 'Masuk'}
            </Title>
            <Paragraph style={styles.subtitle}>
              Sistem Manajemen Parkir
            </Paragraph>

            {isRegister && (
              <TextInput
                label="Nama"
                value={name}
                onChangeText={setName}
                style={styles.input}
                mode="outlined"
                autoCapitalize="words"
              />
            )}

            <TextInput
              label="Email"
              value={email}
              onChangeText={setEmail}
              style={styles.input}
              mode="outlined"
              keyboardType="email-address"
              autoCapitalize="none"
            />

            <TextInput
              label="Password"
              value={password}
              onChangeText={setPassword}
              style={styles.input}
              mode="outlined"
              secureTextEntry
            />

            {isRegister && (
              <TextInput
                label="Konfirmasi Password"
                value={confirmPassword}
                onChangeText={setConfirmPassword}
                style={styles.input}
                mode="outlined"
                secureTextEntry
              />
            )}

            <Button
              mode="contained"
              onPress={isRegister ? handleRegister : handleLogin}
              style={styles.button}
              disabled={loading}
            >
              {loading ? (
                <ActivityIndicator color="white" />
              ) : (
                isRegister ? 'Daftar' : 'Masuk'
              )}
            </Button>

            <Button
              mode="text"
              onPress={() => setIsRegister(!isRegister)}
              style={styles.switchButton}
              disabled={loading}
            >
              {isRegister 
                ? 'Sudah punya akun? Masuk' 
                : 'Belum punya akun? Daftar'}
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
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  scrollContainer: {
    flexGrow: 1,
    justifyContent: 'center',
    padding: 20,
  },
  card: {
    elevation: 4,
    borderRadius: 8,
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    textAlign: 'center',
    marginBottom: 8,
    color: '#007bff',
  },
  subtitle: {
    fontSize: 16,
    textAlign: 'center',
    marginBottom: 24,
    color: '#666',
  },
  input: {
    marginBottom: 16,
  },
  button: {
    paddingVertical: 8,
    marginTop: 16,
    marginBottom: 8,
  },
  switchButton: {
    marginTop: 8,
  },
});
