# 📱 RESTful API Documentation - POS Parkir Mobile

## 🚀 Base URL

```
http://localhost:8000/api/v1
```

## 🔐 Authentication

API menggunakan **Laravel Sanctum** dengan Bearer Token authentication.

### Headers Required:

```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your-token} # untuk protected routes
```

---

## 📋 **API Endpoints**

### **1. Authentication**

#### **POST** `/login`

Login user dan dapatkan access token.

**Request:**

```json
{
    "email": "admin@test.com",
    "password": "password"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@test.com",
            "role": "admin"
        },
        "token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

#### **POST** `/register`

Register user baru.

**Request:**

```json
{
    "name": "New User",
    "email": "user@test.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "petugas"
}
```

#### **GET** `/user` (Protected)

Get data user yang sedang login.

#### **POST** `/logout` (Protected)

Logout dan revoke token.

---

### **2. Vehicle Types**

#### **GET** `/vehicle-types` (Protected)

Get semua jenis kendaraan.

**Response:**

```json
{
    "success": true,
    "message": "Vehicle types retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Motor",
            "flat_rate": 2000,
            "formatted_rate": "Rp 2.000",
            "is_active": true
        },
        {
            "id": 2,
            "name": "Mobil",
            "flat_rate": 5000,
            "formatted_rate": "Rp 5.000",
            "is_active": true
        }
    ],
    "total": 2
}
```

#### **GET** `/demo/vehicle-types`

Demo endpoint tanpa authentication.

---

### **3. Parking Operations**

#### **POST** `/parking` (Protected)

Buat transaksi parkir baru.

**Request:**

```json
{
    "vehicle_type_id": 1,
    "license_plate": "K 1234 ABC",
    "notes": "Catatan opsional"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Parking transaction created successfully",
    "data": {
        "id": 123,
        "ticket_number": "TK25072001",
        "license_plate": "K 1234 ABC",
        "vehicle_type": {
            "id": 1,
            "name": "Motor",
            "rate": 2000
        },
        "amount": 2000,
        "formatted_amount": "Rp 2.000",
        "entry_time": "2025-07-20T15:30:45.000000Z",
        "formatted_entry_time": "20/07/2025 15:30:45",
        "notes": "Catatan opsional",
        "operator": "Admin User"
    }
}
```

#### **GET** `/parking` (Protected)

Get semua transaksi parkir dengan filter.

**Query Parameters:**

-   `period`: `today`, `yesterday`, `week`, `month`
-   `date`: `2025-07-20`
-   `start_date` & `end_date`: `2025-07-01` to `2025-07-31`
-   `license_plate`: `K 1234`
-   `vehicle_type_id`: `1`
-   `limit`: `50` (default)
-   `page`: `1` (default)

#### **GET** `/parking/{id}` (Protected)

Get detail transaksi parkir.

#### **PUT** `/parking/{id}` (Protected)

Update transaksi parkir (license_plate, notes).

#### **DELETE** `/parking/{id}` (Protected, Admin only)

Delete transaksi parkir.

#### **GET** `/parking/{id}/print` (Protected)

Get data untuk print tiket.

**Response:**

```json
{
    "success": true,
    "message": "Print data retrieved successfully",
    "data": {
        "ticket_number": "TK25072001",
        "license_plate": "K 1234 ABC",
        "vehicle_type": "Motor",
        "amount": 2000,
        "formatted_amount": "Rp 2.000",
        "entry_time": "20/07/2025 15:30:45",
        "entry_date": "20/07/2025",
        "entry_time_only": "15:30",
        "operator": "Admin User",
        "location": "POS Parkir System",
        "print_time": "20/07/2025 15:35:22"
    }
}
```

#### **POST** `/demo/parking`

Demo endpoint untuk testing tanpa auth.

---

### **4. Statistics & Reports**

#### **GET** `/stats` (Protected)

Get statistik parkir.

**Query Parameters:**

-   `period`: `today`, `yesterday`, `week`, `month`, `all`

**Response:**

```json
{
    "success": true,
    "message": "Statistics retrieved successfully",
    "data": {
        "period": "today",
        "period_label": "Hari Ini",
        "total_transactions": 25,
        "total_revenue": 125000,
        "formatted_revenue": "Rp 125.000",
        "average_per_transaction": 5000,
        "vehicle_breakdown": [
            {
                "vehicle_type": "Motor",
                "count": 15,
                "revenue": 30000,
                "formatted_revenue": "Rp 30.000"
            },
            {
                "vehicle_type": "Mobil",
                "count": 10,
                "revenue": 95000,
                "formatted_revenue": "Rp 95.000"
            }
        ]
    }
}
```

---

### **5. Sync & Utilities**

#### **POST** `/sync` (Protected)

Sinkronisasi data untuk offline app.

**Request:**

```json
{
    "last_sync_time": "2025-07-20T10:00:00.000000Z"
}
```

#### **GET** `/sync/status` (Protected)

Get status sinkronisasi.

#### **GET** `/health`

Health check endpoint.

**Response:**

```json
{
    "status": "ok",
    "timestamp": "2025-07-20T15:40:00.000000Z",
    "version": "1.0.0"
}
```

---

## 🧪 **Testing API**

### **1. Test dengan Postman/Insomnia:**

1. **Import Collection:**

```json
{
    "info": {
        "name": "POS Parkir Mobile API"
    },
    "item": [
        {
            "name": "Login",
            "request": {
                "method": "POST",
                "url": "{{base_url}}/login",
                "body": {
                    "raw": "{\n  \"email\": \"admin@test.com\",\n  \"password\": \"password\"\n}"
                }
            }
        }
    ]
}
```

### **2. Test dengan cURL:**

```bash
# Login
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"admin@test.com","password":"password"}'

# Get Vehicle Types (with token)
curl -X GET http://localhost:8000/api/v1/vehicle-types \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"

# Create Parking Transaction
curl -X POST http://localhost:8000/api/v1/parking \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"vehicle_type_id":1,"license_plate":"K 1234 ABC","notes":"Test"}'

# Demo endpoints (no auth)
curl -X GET http://localhost:8000/api/v1/demo/vehicle-types \
  -H "Accept: application/json"

curl -X POST http://localhost:8000/api/v1/demo/parking \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"vehicle_type_id":1,"license_plate":"K 1234 ABC"}'
```

---

## 🔒 **Security & Permissions**

### **Role-based Access:**

-   **Admin**: Full access ke semua endpoints
-   **Petugas**: Akses ke parking operations, tidak bisa delete/manage vehicle types

### **Token Management:**

-   Token otomatis expired sesuai config Sanctum
-   Multiple tokens per user supported
-   Revoke token saat logout

### **CORS Configuration:**

API sudah dikonfigurasi untuk menerima request dari mobile app.

---

## 🚀 **Ready for Mobile Integration!**

API ini sudah siap diintegrasikan dengan:

-   ✅ **Expo Snack** - Langsung bisa digunakan
-   ✅ **React Native** - Full support
-   ✅ **Flutter** - REST client compatible
-   ✅ **Progressive Web App** - Fetch API ready

**Start your mobile app development now!** 📱🎉
