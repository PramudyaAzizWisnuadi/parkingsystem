import React, { useState } from 'react';
import { View, StyleSheet } from 'react-native';
import { useApp } from '../../contexts/AppContext';
import LoginScreen from '../../screens/LoginScreen';
import TransactionScreen from '../../screens/TransactionScreen';

export default function HomeScreen() {
  const { isAuthenticated, isLoading } = useApp();
  const [showLogin, setShowLogin] = useState(false);

  if (isLoading) {
    return <View style={styles.container} />;
  }

  // Show login screen if user wants to login
  if (showLogin && !isAuthenticated) {
    return (
      <LoginScreen 
        onLoginSuccess={() => setShowLogin(false)}
      />
    );
  }

  // Show main transaction screen
  return (
    <View style={styles.container}>
      <TransactionScreen />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
});
