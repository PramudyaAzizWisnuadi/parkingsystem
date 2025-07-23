# 🧪 Testing API dengan Postman - Panduan Lengkap

## 📋 Daftar Endpoint untuk Testing

### 🔥 Base URL

```
http://localhost:8000/api/v1
```

---

## 1. 🏥 Health Check (Public)

### GET Health Check

```
GET http://localhost:8000/api/v1/health
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
```

**Expected Response:**

```json
{
    "status": "success",
    "message": "API is running",
    "timestamp": "2025-07-21T10:30:00.000000Z",
    "version": "v1"
}
```

---

## 2. 🚗 Vehicle Types (Demo - No Auth)

### GET Demo Vehicle Types

```
GET http://localhost:8000/api/v1/demo/vehicle-types
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
```

**Expected Response:**

```json
{
    "success": true,
    "message": "Demo vehicle types retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Motor",
            "flat_rate": 2000,
            "rate": 2000,
            "formatted_rate": "Rp 2.000",
            "is_active": true
        },
        {
            "id": 2,
            "name": "Mobil",
            "flat_rate": 5000,
            "rate": 5000,
            "formatted_rate": "Rp 5.000",
            "is_active": true
        },
        {
            "id": 3,
            "name": "Truk",
            "flat_rate": 10000,
            "rate": 10000,
            "formatted_rate": "Rp 10.000",
            "is_active": true
        }
    ],
    "total": 3,
    "note": "This is demo data for testing purposes"
}
```

---

## 3. 🔐 Authentication

### POST Login

```
POST http://localhost:8000/api/v1/login
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
```

**Body (JSON):**

```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

**Expected Response:**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "role": "admin"
        },
        "token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

**⚠️ PENTING:** Salin token dari response untuk digunakan di request selanjutnya!

### POST Register

```
POST http://localhost:8000/api/v1/register
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
```

**Body (JSON):**

```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

---

## 4. 🚗 Vehicle Types (Authenticated)

### GET Vehicle Types (Auth Required)

```
GET http://localhost:8000/api/v1/vehicle-types
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

### GET Single Vehicle Type

```
GET http://localhost:8000/api/v1/vehicle-types/1
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

### POST Create Vehicle Type (Admin Only)

```
POST http://localhost:8000/api/v1/vehicle-types
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Body (JSON):**

```json
{
    "name": "Bus",
    "flat_rate": 15000,
    "is_active": true
}
```

### PUT Update Vehicle Type (Admin Only)

```
PUT http://localhost:8000/api/v1/vehicle-types/1
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Body (JSON):**

```json
{
    "name": "Motor Besar",
    "flat_rate": 3000,
    "is_active": true
}
```

---

## 5. 🅿️ Parking Operations

### GET Parking History

```
GET http://localhost:8000/api/v1/parking
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Query Parameters (Optional):**

```
?page=1&per_page=10&period=today&license_plate=B1234&vehicle_type_id=1
```

### POST Create Parking Transaction

```
POST http://localhost:8000/api/v1/parking
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Body (JSON):**

```json
{
    "vehicle_type_id": 1,
    "license_plate": "B 1234 TEST",
    "notes": "Test parking transaction dari Postman"
}
```

### POST Demo Parking Transaction (No Auth)

```
POST http://localhost:8000/api/v1/demo/parking
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
```

**Body (JSON):**

```json
{
    "vehicle_type_id": 1,
    "license_plate": "B 5678 DEMO",
    "notes": "Demo transaction untuk testing"
}
```

### GET Single Parking Transaction

```
GET http://localhost:8000/api/v1/parking/1
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 6. 📊 Statistics & Reports

### GET Statistics

```
GET http://localhost:8000/api/v1/stats
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Query Parameters:**

```
?period=today
```

Options: `today`, `yesterday`, `week`, `month`, `all`

### GET Daily Report

```
GET http://localhost:8000/api/v1/reports/daily
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

### GET Monthly Report

```
GET http://localhost:8000/api/v1/reports/monthly
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 7. 🔄 Sync Operations

### POST Sync Data

```
POST http://localhost:8000/api/v1/sync
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

**Body (JSON) - Optional:**

```json
{
    "last_sync_time": "2025-07-20T10:00:00.000Z"
}
```

### GET Sync Status

```
GET http://localhost:8000/api/v1/sync/status
```

**Headers:**

```
Accept: application/json
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 🚀 Cara Testing di Postman

### Step 1: Setup Environment

1. Buka Postman
2. Create New Environment: `Parking API`
3. Add Variables:
    - `base_url`: `http://localhost:8000/api/v1`
    - `token`: (akan diisi setelah login)

### Step 2: Test Public Endpoints

1. **Health Check** - pastikan API running
2. **Demo Vehicle Types** - cek format unified
3. **Demo Parking** - test tanpa auth

### Step 3: Authentication

1. **Login** dengan credentials yang ada
2. **Copy token** dari response
3. **Set token** di environment variable

### Step 4: Test Authenticated Endpoints

1. **Vehicle Types** - cek format unified dengan auth
2. **Parking Operations** - CRUD operations
3. **Statistics** - cek reporting
4. **Sync** - test sync functionality

### Step 5: Test Admin Features (jika role admin)

1. **Create Vehicle Type**
2. **Update Vehicle Type**
3. **Delete Vehicle Type** (hati-hati!)

---

## 🔍 Validation Points

### ✅ Format Unified Vehicle Types

Pastikan response mengandung:

```json
{
    "flat_rate": 2000, // Untuk web
    "rate": 2000, // Untuk mobile
    "formatted_rate": "Rp 2.000"
}
```

### ✅ Parking Transaction Format

Pastikan vehicle_type dalam transaction:

```json
{
    "vehicle_type": {
        "id": 1,
        "name": "Motor",
        "rate": 2000
    }
}
```

### ✅ Error Handling

Test error cases:

-   Invalid credentials
-   Missing required fields
-   Unauthorized access
-   Non-existent resources

---

## 📱 Testing Mobile Compatibility

### Test Vehicle Types Format:

```bash
# Cek apakah response mengandung kedua field
curl -X GET "http://localhost:8000/api/v1/demo/vehicle-types" \
  -H "Accept: application/json" | grep -E '"(flat_)?rate"'
```

### Test Parking Format:

```bash
# Cek format vehicle_type dalam parking transaction
curl -X POST "http://localhost:8000/api/v1/demo/parking" \
  -H "Content-Type: application/json" \
  -d '{"vehicle_type_id":1,"license_plate":"TEST"}' | grep "vehicle_type"
```

---

## 🐛 Common Issues & Solutions

### Issue: "Unauthenticated"

**Solution:** Pastikan Authorization header dengan Bearer token

### Issue: "403 Forbidden"

**Solution:** User bukan admin untuk endpoint yang memerlukan admin

### Issue: "Connection refused"

**Solution:** Pastikan Laravel server running: `php artisan serve --host=0.0.0.0 --port=8000`

### Issue: Missing unified format

**Solution:** Pastikan VehicleTypeApiController sudah diupdate dengan field `rate`

---

**Happy Testing! 🎯**
