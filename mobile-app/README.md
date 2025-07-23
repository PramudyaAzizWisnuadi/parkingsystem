# 🚗 Aplikasi Mobile Parking System

Aplikasi mobile untuk sistem manajemen parkir menggunakan **Expo Snack** dan terintegrasi dengan **Laravel API**.

## 🚀 Cara Menggunakan di Expo Snack

### 1. Buka Expo Snack

-   Kunjungi [snack.expo.dev](https://snack.expo.dev)
-   Buat project baru

### 2. Copy File-file Berikut

Salin semua file dari folder `mobile-app/` ke Expo Snack:

#### File Utama:

-   `App.js` - Entry point aplikasi
-   `package.json` - Dependencies

#### Context (State Management):

-   `context/AuthContext.js` - Manajemen autentikasi
-   `context/ParkingContext.js` - Manajemen data parkir

#### Services:

-   `services/ApiService.js` - Komunikasi dengan API

#### Screens:

-   `screens/LoginScreen.js` - Halaman login/register
-   `screens/HomeScreen.js` - Dashboard utama
-   `screens/ParkingEntryScreen.js` - Form transaksi parkir
-   `screens/HistoryScreen.js` - Riwayat transaksi
-   `screens/SettingsScreen.js` - Pengaturan user

### 3. Konfigurasi API

Edit file `services/ApiService.js`:

```javascript
// Ganti localhost dengan IP address komputer Anda
const BASE_URL = "http://192.168.1.100:8000/api/v1";
```

**Cara mendapatkan IP Address:**

-   Windows: Buka CMD, ketik `ipconfig`
-   Mac/Linux: Buka Terminal, ketik `ifconfig`
-   Gunakan IP dari WiFi/Ethernet yang aktif

### 4. Jalankan Laravel API Server

Di terminal komputer Anda:

```bash
cd d:\laragon\www\mdparkir
php artisan serve --host=0.0.0.0 --port=8000
```

### 5. Test Aplikasi

-   Buka aplikasi di Expo Go (Android/iOS)
-   Login dengan:
    -   Email: `admin@parkir.com`
    -   Password: `password`

## 📱 Fitur Aplikasi

### 🔐 Authentication

-   Login dengan email & password
-   Register user baru
-   Auto-logout session management

### 🏠 Dashboard

-   Statistik parkir hari ini
-   Total transaksi & pendapatan
-   Parkir aktif & slot tersisa
-   Transaksi terbaru

### 🅿️ Transaksi Parkir

-   Input plat kendaraan
-   Pilih jenis kendaraan
-   Kalkulasi tarif otomatis
-   Generate tiket dengan nomor unik

### 📊 Riwayat

-   List semua transaksi
-   Search berdasarkan plat/tiket
-   Filter status (aktif/selesai)
-   Refresh to update

### ⚙️ Settings

-   Profile user
-   Info aplikasi
-   Logout

## 🛠️ Dependencies

```json
{
    "expo": "~49.0.0",
    "react-native-paper": "^5.10.0",
    "@react-navigation/native": "^6.1.0",
    "@react-navigation/bottom-tabs": "^6.5.0",
    "@react-navigation/stack": "^6.3.0",
    "axios": "^1.5.0",
    "@react-native-async-storage/async-storage": "1.18.2"
}
```

## 🌐 API Endpoints

### Authentication:

-   `POST /login` - Login user
-   `POST /register` - Register user baru
-   `POST /logout` - Logout user
-   `GET /user` - Get user profile

### Demo Endpoints (Tanpa Auth):

-   `GET /demo/vehicle-types` - List jenis kendaraan
-   `POST /demo/parking` - Buat transaksi demo

### Protected Endpoints:

-   `GET /parking` - List transaksi
-   `POST /parking` - Buat transaksi baru
-   `GET /stats` - Statistik parkir
-   `GET /reports/daily` - Laporan harian

## 🔧 Troubleshooting

### 1. Error Connection Refused

-   Pastikan Laravel server running
-   Cek IP address sudah benar
-   Pastikan firewall tidak memblokir port 8000

### 2. CORS Error

-   Laravel sudah dikonfigurasi CORS untuk mobile
-   Jika masih error, restart Laravel server

### 3. Authentication Error

-   Pastikan user ada di database
-   Cek credentials: admin@parkir.com / password

### 4. Slow Loading

-   Pastikan koneksi internet stabil
-   Cek response time API dengan curl/Postman

## 📝 Notes

-   Aplikasi menggunakan AsyncStorage untuk menyimpan token
-   Material Design dengan react-native-paper
-   Responsive design untuk phone & tablet
-   Support offline detection (coming soon)

## 🎯 Demo Credentials

**Admin:**

-   Email: admin@parkir.com
-   Password: password

**Petugas:**

-   Email: petugas@parkir.com
-   Password: password

## 📧 Support

Untuk bantuan lebih lanjut:

-   Email: admin@parkir.com
-   GitHub Issues: [Repository Link]

---

🚀 **Ready to use in Expo Snack!**
