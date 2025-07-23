import React from 'react';
import {
  View,
  StyleSheet,
  ScrollView,
  Alert,
} from 'react-native';
import {
  Card,
  Title,
  Paragraph,
  List,
  Button,
  Divider,
  Avatar,
} from 'react-native-paper';
import { useAuth } from '../context/AuthContext';

export default function SettingsScreen() {
  const { user, logout } = useAuth();

  const handleLogout = () => {
    Alert.alert(
      'Konfirmasi Logout',
      'Apakah Anda yakin ingin keluar?',
      [
        { text: 'Batal', style: 'cancel' },
        { text: 'Keluar', onPress: logout },
      ]
    );
  };

  const handleAbout = () => {
    Alert.alert(
      'Tentang Aplikasi',
      'Sistem Manajemen Parkir\nVersi 1.0.0\n\nDibuat dengan React Native dan Expo\nTerintegrasi dengan Laravel API',
      [{ text: 'OK' }]
    );
  };

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('id-ID', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });
  };

  return (
    <ScrollView style={styles.container}>
      <Card style={styles.profileCard}>
        <Card.Content>
          <View style={styles.profileHeader}>
            <Avatar.Text 
              size={64} 
              label={user?.name?.charAt(0)?.toUpperCase() || 'U'}
              style={styles.avatar}
            />
            <View style={styles.profileInfo}>
              <Title style={styles.userName}>{user?.name}</Title>
              <Paragraph style={styles.userEmail}>{user?.email}</Paragraph>
              <Paragraph style={styles.userRole}>
                {user?.role === 'admin' ? 'Administrator' : 'Petugas'}
              </Paragraph>
              {user?.created_at && (
                <Paragraph style={styles.joinDate}>
                  Bergabung sejak {formatDate(user.created_at)}
                </Paragraph>
              )}
            </View>
          </View>
        </Card.Content>
      </Card>

      <Card style={styles.menuCard}>
        <Card.Content>
          <Title style={styles.menuTitle}>Pengaturan Akun</Title>
          
          <List.Item
            title="Profil Saya"
            description="Lihat dan edit informasi profil"
            left={props => <List.Icon {...props} icon="account-circle" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert('Info', 'Fitur ini akan tersedia dalam update mendatang');
            }}
          />
          
          <Divider />
          
          <List.Item
            title="Ganti Password"
            description="Ubah kata sandi akun Anda"
            left={props => <List.Icon {...props} icon="lock" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert('Info', 'Fitur ini akan tersedia dalam update mendatang');
            }}
          />
        </Card.Content>
      </Card>

      <Card style={styles.menuCard}>
        <Card.Content>
          <Title style={styles.menuTitle}>Aplikasi</Title>
          
          <List.Item
            title="Notifikasi"
            description="Atur preferensi notifikasi"
            left={props => <List.Icon {...props} icon="bell" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert('Info', 'Fitur ini akan tersedia dalam update mendatang');
            }}
          />
          
          <Divider />
          
          <List.Item
            title="Tema"
            description="Pilih tema aplikasi"
            left={props => <List.Icon {...props} icon="palette" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert('Info', 'Fitur ini akan tersedia dalam update mendatang');
            }}
          />
          
          <Divider />
          
          <List.Item
            title="Bahasa"
            description="Indonesia"
            left={props => <List.Icon {...props} icon="translate" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert('Info', 'Fitur ini akan tersedia dalam update mendatang');
            }}
          />
        </Card.Content>
      </Card>

      <Card style={styles.menuCard}>
        <Card.Content>
          <Title style={styles.menuTitle}>Dukungan</Title>
          
          <List.Item
            title="Bantuan"
            description="Panduan penggunaan aplikasi"
            left={props => <List.Icon {...props} icon="help-circle" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert(
                'Bantuan',
                'Untuk bantuan lebih lanjut, silakan hubungi:\n\nEmail: admin@parkir.com\nTelepon: (021) 123-4567',
                [{ text: 'OK' }]
              );
            }}
          />
          
          <Divider />
          
          <List.Item
            title="Tentang"
            description="Informasi aplikasi"
            left={props => <List.Icon {...props} icon="information" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={handleAbout}
          />
          
          <Divider />
          
          <List.Item
            title="Kebijakan Privasi"
            description="Baca kebijakan privasi kami"
            left={props => <List.Icon {...props} icon="shield-account" />}
            right={props => <List.Icon {...props} icon="chevron-right" />}
            onPress={() => {
              Alert.alert('Info', 'Fitur ini akan tersedia dalam update mendatang');
            }}
          />
        </Card.Content>
      </Card>

      <Card style={styles.logoutCard}>
        <Card.Content>
          <Button
            mode="contained"
            onPress={handleLogout}
            icon="logout"
            buttonColor="#dc3545"
            style={styles.logoutButton}
          >
            Keluar
          </Button>
          
          <Paragraph style={styles.versionText}>
            Versi 1.0.0 - Build 2025
          </Paragraph>
        </Card.Content>
      </Card>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
    padding: 16,
  },
  profileCard: {
    marginBottom: 16,
    elevation: 2,
  },
  profileHeader: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  avatar: {
    marginRight: 16,
    backgroundColor: '#007bff',
  },
  profileInfo: {
    flex: 1,
  },
  userName: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 2,
  },
  userEmail: {
    fontSize: 14,
    color: '#666',
    marginBottom: 2,
  },
  userRole: {
    fontSize: 14,
    color: '#007bff',
    fontWeight: '500',
    marginBottom: 4,
  },
  joinDate: {
    fontSize: 12,
    color: '#888',
  },
  menuCard: {
    marginBottom: 16,
    elevation: 2,
  },
  menuTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 8,
    color: '#333',
  },
  logoutCard: {
    marginBottom: 32,
    elevation: 2,
  },
  logoutButton: {
    paddingVertical: 8,
    marginBottom: 16,
  },
  versionText: {
    fontSize: 12,
    textAlign: 'center',
    color: '#888',
  },
});
