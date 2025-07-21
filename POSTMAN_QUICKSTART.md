# 🚀 Quick Start: Testing API dengan Postman

## ✅ Server Status: RUNNING
```
✅ Laravel Server: http://localhost:8000
✅ API Base URL: http://localhost:8000/api/v1
✅ Health Check: WORKING
✅ Demo Endpoints: WORKING
✅ Unified Format: CONFIRMED
```

## 📥 Import ke Postman

### Option 1: Import Collection File
1. **Download file**: `Parking_API_Collection.postman_collection.json`
2. **Buka Postman** → Import → Choose File
3. **Select file** yang sudah didownload
4. **Collection siap digunakan!**

### Option 2: Import via Raw JSON
1. **Buka Postman** → Import → Raw Text
2. **Copy-paste** isi file `Parking_API_Collection.postman_collection.json`
3. **Import** → Collection akan tersedia

## 🔧 Setup Environment

### Create Environment: "Parking API"
```
Variable Name: base_url
Value: http://localhost:8000/api/v1

Variable Name: token  
Value: (akan diisi otomatis setelah login)
```

## 🧪 Test Sequence (Recommended)

### Step 1: Test Public Endpoints ✅
```
1. Health Check → Pastikan API running
2. Demo Vehicle Types → Cek format unified (flat_rate + rate)
3. Demo Parking Transaction → Test tanpa auth
```

### Step 2: Authentication ✅
```
1. Login dengan:
   Email: admin@example.com
   Password: password
   
2. Token akan otomatis tersimpan ke environment
```

### Step 3: Test Authenticated Endpoints
```
1. Get Vehicle Types → Cek format unified dengan auth
2. Get Parking History → Lihat data existing
3. Create Parking Transaction → Test CRUD
4. Get Statistics → Test reporting
```

### Step 4: Test Admin Features (jika role admin)
```
1. Create Vehicle Type → Test admin permissions
2. Update Vehicle Type → Test modification
3. Admin-only endpoints
```

## 📊 Key Testing Points

### ✅ Format Unified Validation
Pastikan response Vehicle Types mengandung:
```json
{
    "flat_rate": 2000,    // Untuk web compatibility
    "rate": 2000,         // Untuk mobile compatibility
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
        "rate": 2000    // Unified field
    }
}
```

## 🎯 Sample Test Results

### Health Check ✅
```json
{
    "status": "success",
    "message": "API is running",
    "timestamp": "2025-07-21T08:03:47.226752Z",
    "version": "v1"
}
```

### Demo Vehicle Types ✅ (Unified Format)
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Motor",
            "flat_rate": 2000,    ← Web format
            "rate": 2000,         ← Mobile format
            "formatted_rate": "Rp 2.000",
            "is_active": true
        }
    ]
}
```

### Demo Parking Transaction ✅
```json
{
    "success": true,
    "data": {
        "ticket_number": "DEMO250721150446",
        "vehicle_type": {
            "id": 1,
            "name": "Motor",
            "rate": 2000      ← Unified field
        },
        "amount": 2000,
        "formatted_amount": "Rp 2.000"
    }
}
```

## 🔐 Authentication Flow

### Login Request:
```json
POST /api/v1/login
{
    "email": "admin@example.com",
    "password": "password"
}
```

### Login Response:
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "role": "admin"
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### Use Token:
```
Authorization: Bearer 1|abc123...
```

## 🐛 Troubleshooting

### ❌ Connection Refused
**Solution:** Pastikan Laravel server running
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### ❌ Unauthenticated  
**Solution:** Pastikan token valid di Authorization header

### ❌ 403 Forbidden
**Solution:** User bukan admin untuk endpoint admin-only

### ❌ Validation Error
**Solution:** Cek required fields dan format data

## 📱 Mobile Compatibility Testing

### Test Format Unified:
- ✅ Field `flat_rate` tersedia (web compatibility)
- ✅ Field `rate` tersedia (mobile compatibility)  
- ✅ Values sama untuk kedua field
- ✅ Formatted rate tersedia

### Test Cross-Platform:
1. **Web App** → Create parking transaction
2. **API GET** → Data muncul dengan format unified
3. **Mobile App** → Bisa read data dengan field `rate`

---

## 🎉 Summary

✅ **API Server**: Running di http://localhost:8000  
✅ **Postman Collection**: Ready to import  
✅ **Unified Format**: Confirmed working  
✅ **Demo Endpoints**: All working without auth  
✅ **Authentication**: Working with token auto-save  
✅ **CRUD Operations**: All endpoints available  
✅ **Mobile Compatibility**: Format unified ready  

**Happy Testing! 🚀**

**Next Step**: Import collection ke Postman dan mulai testing!
