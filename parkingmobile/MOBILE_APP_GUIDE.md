# Parking Mobile App

Aplikasi mobile untuk sistem parkir yang terintegrasi dengan API Laravel.

## Fitur Utama

### 🎯 **Transaksi Parkir**

-   Buat transaksi parkir baru
-   Pilih jenis kendaraan (Motor, Mobil, Truk)
-   Input plat nomor (opsional)
-   Tambah catatan (opsional)
-   Generate tiket parkir otomatis

### 📱 **Mode Demo dan Authenticated**

-   **Mode Demo**: Buat transaksi tanpa menyimpan ke database
-   **Mode Authenticated**: Login untuk menyimpan transaksi ke server
-   Toggle mudah antara mode demo dan login

### 📋 **Riwayat Transaksi**

-   Lihat semua transaksi (hanya untuk user yang login)
-   Filter dan pencarian
-   Detail lengkap setiap transaksi
-   Refresh dan load more

## Teknologi

-   **React Native** dengan Expo
-   **React Navigation** untuk navigasi
-   **AsyncStorage** untuk penyimpanan lokal
-   **Fetch API** untuk komunikasi dengan server

## Struktur Aplikasi

```
parkingmobile/
├── app/                      # Expo Router structure
│   ├── (tabs)/
│   │   ├── index.tsx        # Tab Transaksi
│   │   ├── history.tsx      # Tab Riwayat
│   │   └── _layout.tsx      # Tab Navigation
│   └── _layout.tsx          # Root Layout dengan AppProvider
├── screens/                  # Screen components
│   ├── TransactionScreen.js  # Form transaksi parkir
│   ├── LoginScreen.js        # Form login
│   └── HistoryScreen.js      # Daftar riwayat transaksi
├── contexts/                 # React Context
│   └── AppContext.js         # Global state management
└── services/                 # API services
    └── ApiService.js         # API communication layer
```

## Setup dan Instalasi

### 1. Prerequisites

-   Node.js (v16 atau lebih baru)
-   Expo CLI: `npm install -g expo-cli`
-   Server Laravel berjalan di `http://192.168.1.100:8000`

### 2. Install Dependencies

```bash
cd parkingmobile
npm install
```

### 3. Konfigurasi API

Edit file `services/ApiService.js` dan ubah `baseURL`:

```javascript
this.baseURL = "http://IP_SERVER_ANDA:8000/api/v1";
```

### 4. Jalankan Aplikasi

```bash
npm start
# atau
expo start
```

## API Integration

Aplikasi ini terintegrasi dengan endpoint API berikut:

### Authentication

-   `POST /api/v1/auth/login` - Login user
-   `POST /api/v1/auth/logout` - Logout user

### Vehicle Types

-   `GET /api/v1/vehicle-types` - Get vehicle types (dengan auth)
-   `GET /api/v1/vehicle-types/demo` - Get vehicle types (tanpa auth)

### Parking Transactions

-   `GET /api/v1/parking` - Get all transactions (dengan auth)
-   `POST /api/v1/parking` - Create transaction (dengan auth)
-   `POST /api/v1/parking/demo` - Create demo transaction (tanpa auth)
-   `GET /api/v1/parking/{id}` - Get specific transaction
-   `GET /api/v1/parking/{id}/print` - Get print data
-   `GET /api/v1/parking/stats` - Get statistics

### Health Check

-   `GET /api/v1/health` - Server health check

## Cara Penggunaan

### Mode Demo

1. Buka aplikasi
2. Pilih jenis kendaraan
3. Isi plat nomor (opsional)
4. Tambah catatan (opsional)
5. Tekan "BUAT TRANSAKSI"
6. Lihat tiket yang generated

### Mode Authenticated

1. Tekan tombol "LOGIN" di header
2. Masukkan credentials:
    - Email: `admin@example.com`
    - Password: `password`
3. Setelah login, transaksi akan disimpan ke database
4. Akses tab "Riwayat" untuk melihat semua transaksi

## Fitur Aplikasi

### 🎨 **UI/UX Features**

-   Material Design dengan warna konsisten
-   Responsive design untuk berbagai ukuran layar
-   Loading states dan error handling
-   Alert confirmations untuk aksi penting
-   Pull to refresh pada daftar riwayat
-   Modal tiket yang informatif

### 🔒 **Security Features**

-   JWT token authentication
-   Automatic token storage dan retrieval
-   Secure logout dengan cleanup
-   API error handling

### 📊 **Data Management**

-   Offline-ready dengan fallback data
-   Real-time data sync dengan server
-   Automatic retry pada network error
-   Local storage untuk session persistence

## Troubleshooting

### API Connection Issues

1. Pastikan server Laravel berjalan
2. Periksa IP address di `ApiService.js`
3. Pastikan tidak ada firewall blocking
4. Test dengan endpoint `/api/v1/health`

### Authentication Issues

1. Periksa credentials default: `admin@example.com` / `password`
2. Clear AsyncStorage jika ada masalah token
3. Restart aplikasi setelah perubahan

### Build Issues

1. Clear Expo cache: `expo start -c`
2. Delete node_modules dan reinstall
3. Pastikan semua dependencies terinstall

## Development

### Testing

-   Test di Expo Go untuk development
-   Build production untuk testing di device
-   Test semua mode: demo dan authenticated

### Customization

-   Ubah warna di `styles` setiap screen
-   Modify API endpoints di `ApiService.js`
-   Add fitur baru di screens dan update context

## Production Deployment

### Build for Production

```bash
# Build untuk Android
expo build:android

# Build untuk iOS
expo build:ios
```

### Environment Configuration

-   Set production API URL
-   Configure app icons dan splash screen
-   Setup app store metadata

## Support

Untuk bantuan atau pertanyaan:

1. Periksa troubleshooting di atas
2. Check server Laravel logs
3. Monitor network requests di Expo DevTools
4. Test API endpoints dengan Postman collection yang sudah disediakan
