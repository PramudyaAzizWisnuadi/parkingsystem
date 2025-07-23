# 🔧 Cara Perbaiki Jenis Kendaraan di Expo Snack

## ✅ **Masalah yang Diperbaiki:**

-   API mengembalikan `vehicle_type` sebagai object `{id, name, rate}`
-   Aplikasi mobile sekarang handle format yang benar
-   Error handling yang lebih baik
-   Console logging untuk debugging

## 📱 **Setup di Expo Snack:**

### 1. **Update BASE_URL di ApiService.js:**

```javascript
const BASE_URL = "http://YOUR_IP_ADDRESS:8000/api/v1";
```

**Cara mendapatkan IP:**

-   Windows: `ipconfig` (cari IPv4 Address)
-   Mac/Linux: `ifconfig` (cari inet)
-   Contoh: `http://192.168.1.100:8000/api/v1`

### 2. **Copy File yang Sudah Diperbaiki:**

-   `services/ApiService.js` ✅
-   `context/ParkingContext.js` ✅
-   `screens/ParkingEntryScreen.js` ✅
-   `screens/HistoryScreen.js` ✅
-   `screens/Debug.js` ✅ (opsional - untuk testing)

### 3. **Start Laravel Server:**

```bash
cd d:\laragon\www\mdparkir
php artisan serve --host=0.0.0.0 --port=8000
```

## 🧪 **Debug & Testing:**

### Test API di Browser:

```
http://YOUR_IP:8000/api/v1/health
http://YOUR_IP:8000/api/v1/demo/vehicle-types
```

### Enable Console di Expo Snack:

1. Buka Developer Tools (F12)
2. Lihat Console tab
3. Aplikasi akan log semua API calls

### Tambahkan Debug Screen (Opsional):

Add to your navigation tabs untuk testing:

```javascript
<Tab.Screen name="Debug" component={Debug} options={{ title: "Debug" }} />
```

## 📊 **Format Data yang Benar:**

### Vehicle Types API Response:

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Motor",
            "flat_rate": 2000,
            "formatted_rate": "Rp 2.000",
            "is_active": true
        }
    ]
}
```

### Parking Transaction Response:

```json
{
    "success": true,
    "data": {
        "id": 1234,
        "ticket_number": "DEMO250720162401",
        "license_plate": "B1234XY",
        "vehicle_type": {
            "id": 2,
            "name": "Mobil",
            "rate": 5000
        },
        "amount": 5000,
        "formatted_amount": "Rp 5.000"
    }
}
```

## ✅ **Fitur yang Diperbaiki:**

1. **✅ Jenis Kendaraan:**

    - Load dari API dengan benar
    - Display tarif yang sesuai
    - Error handling jika API gagal

2. **✅ Transaksi Parkir:**

    - Kirim vehicle_type_id yang benar
    - Tampilkan konfirmasi dengan data yang tepat
    - Generate tiket dengan info lengkap

3. **✅ History:**

    - Tampilkan jenis kendaraan dari API
    - Format data yang konsisten
    - Pagination dan search

4. **✅ Error Handling:**
    - Fallback data jika API error
    - User-friendly error messages
    - Console logging untuk debugging

## 🚀 **Testing Steps:**

1. **Test Health Check:**

    - Buka aplikasi
    - Cek console untuk "Fetching vehicle types..."
    - Harus muncul 3 jenis: Motor, Mobil, Truk

2. **Test Parking Entry:**

    - Buka tab "Entry"
    - Harus muncul 3 pilihan kendaraan
    - Pilih satu, harus muncul tarif yang benar
    - Submit transaksi

3. **Test History:**
    - Buka tab "History"
    - Harus muncul data transaksi
    - Jenis kendaraan harus sesuai

## 🔧 **Troubleshooting:**

### Jika Vehicle Types tidak muncul:

1. Cek console untuk error messages
2. Pastikan Laravel server running
3. Pastikan IP address benar di ApiService.js
4. Test health check endpoint

### Jika Error "Network request failed":

1. Pastikan phone dan computer di WiFi yang sama
2. Pastikan firewall tidak block port 8000
3. Test API di browser dulu

---

**Sekarang jenis kendaraan akan sesuai dengan API dan berfungsi dengan sempurna!** 🎉
