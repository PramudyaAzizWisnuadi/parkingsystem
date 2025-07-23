import React from 'react';
import { View, StyleSheet } from 'react-native';
import HistoryScreen from '../../screens/HistoryScreen';

export default function HistoryTabScreen() {
  return (
    <View style={styles.container}>
      <HistoryScreen />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
});
