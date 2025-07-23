# 📱 Aplikasi Mobile Parkir - Versi Unified

## 🎯 Tujuan Update

Update ini dibuat untuk **menyesuaikan format data aplikasi mobile agar konsisten dengan aplikasi web** yang sudah ada. Sekarang kedua aplikasi menggunakan format data yang sama.

## 🔄 Perubahan Utama

### 1. API Backend (Laravel) - Unified Format

-   **VehicleTypeApiController**: Menambahkan field `rate` sekaligus mempertahankan `flat_rate` untuk kompatibilitas
-   **ParkingApiController**: Memastikan format response konsisten antara web dan mobile
-   **Format Data Unified**:
    ```json
    {
        "id": 1,
        "name": "Motor",
        "flat_rate": 2000, // Untuk web compatibility
        "rate": 2000, // Untuk mobile compatibility
        "formatted_rate": "Rp 2.000"
    }
    ```

### 2. Mobile App - Unified Compatibility

-   **ApiService.js**: Helper methods untuk handle format data unified
-   **ParkingContext.js**: State management yang mendukung kedua format
-   **ParkingEntryScreen.js**: UI yang konsisten dengan web untuk pemilihan jenis kendaraan
-   **HistoryScreen.js**: Display data yang mendukung format unified

## 📁 File Yang Diupdate

### Mobile App (folder: `mobile-app-unified/`)

1. `ApiService.js` - Service layer dengan format unified
2. `ParkingContext.js` - Context dengan compatibility untuk kedua format
3. `ParkingEntryScreen.js` - Screen entry dengan format yang sesuai web
4. `HistoryScreen.js` - History dengan display format unified
5. `Debug.js` - Testing utilities untuk format unified

### API Backend (Laravel)

1. `app/Http/Controllers/Api/VehicleTypeApiController.php` - Menambah field `rate`
2. Response format sekarang mendukung kedua aplikasi

## 🚀 Cara Deploy

### 1. Update API (Laravel)

API sudah diupdate secara otomatis. Restart Laravel server:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### 2. Deploy Mobile App ke Expo Snack

1. **Buka Expo Snack**: https://snack.expo.dev/
2. **Salin file-file berikut dari folder `mobile-app-unified/`**:

    **File App.js (gunakan yang sudah ada sebelumnya)**

    **File services/ApiService.js**:

    ```javascript
    // Salin isi dari mobile-app-unified/ApiService.js
    // Jangan lupa update BASE_URL dengan IP Address Anda
    ```

    **File context/ParkingContext.js**:

    ```javascript
    // Salin isi dari mobile-app-unified/ParkingContext.js
    ```

    **File screens/ParkingEntryScreen.js**:

    ```javascript
    // Salin isi dari mobile-app-unified/ParkingEntryScreen.js
    ```

    **File screens/HistoryScreen.js**:

    ```javascript
    // Salin isi dari mobile-app-unified/HistoryScreen.js
    ```

    **File screens/Debug.js**:

    ```javascript
    // Salin isi dari mobile-app-unified/Debug.js
    ```

3. **Update BASE_URL**:
   Di file `services/ApiService.js`, ganti:
    ```javascript
    const BASE_URL = "http://YOUR_IP_ADDRESS:8000/api/v1";
    ```
    Dengan IP address komputer Anda.

## 🔧 Testing

### 1. Test API Response Format

Gunakan screen Debug di mobile app untuk test:

-   Health Check
-   Vehicle Types (format unified)
-   Parking History
-   Demo Transaction
-   Format Compatibility Test

### 2. Test Consistency

-   Buat transaksi di **web application**
-   Lihat di **mobile app history** - data harus muncul dengan format yang benar
-   Buat transaksi di **mobile app**
-   Lihat di **web application** - data harus konsisten

## 📊 Format Data Unified

### Vehicle Type Response

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Motor",
            "flat_rate": 2000, // Web format
            "rate": 2000, // Mobile format
            "formatted_rate": "Rp 2.000",
            "is_active": true
        }
    ]
}
```

### Parking Transaction Response

```json
{
    "id": 1,
    "ticket_number": "TKT202507201234",
    "license_plate": "B 1234 ABC",
    "vehicle_type": {
        "id": 1,
        "name": "Motor",
        "rate": 2000 // Unified field
    },
    "amount": 2000,
    "formatted_amount": "Rp 2.000",
    "entry_time": "2025-07-20T10:30:00.000Z",
    "formatted_entry_time": "20/07/2025 10:30:00"
}
```

## ✅ Keuntungan Update Ini

1. **Data Konsisten**: Web dan mobile menggunakan format data yang sama
2. **Backward Compatible**: Aplikasi lama tetap berfungsi
3. **Forward Compatible**: Update future lebih mudah
4. **Single Source of Truth**: Satu API untuk dua platform
5. **Easier Maintenance**: Tidak perlu maintain format berbeda

## 🐛 Troubleshooting

### Jika Vehicle Types tidak muncul:

1. Cek Debug screen - test "Demo Vehicle Types"
2. Pastikan Laravel server running
3. Cek BASE_URL di ApiService.js

### Jika History tidak muncul:

1. Cek network connection
2. Test di Debug screen
3. Pastikan ada data di database web

### Jika format tarif salah:

1. API sekarang return kedua field `rate` dan `flat_rate`
2. Mobile app otomatis handle kedua format
3. Cek di Debug screen "Format Test"

## 📞 Support

Jika ada masalah:

1. Gunakan Debug screen untuk test koneksi
2. Cek console log di browser/metro
3. Pastikan Laravel dan mobile app menggunakan IP yang sama

---

**Update berhasil! Sekarang aplikasi web dan mobile Anda menggunakan format data yang konsisten dan unified.** 🎉
