# 🔧 Troubleshooting Guide: Role Access Issues

## ❌ Problem: Admin dan Petugas tidak dapat create transaksi parkir

### ✅ Solutions Applied:

#### 1. **Database Structure Check**

```sql
-- Pastikan kolom 'role' ada di table users
PRAGMA table_info(users);
```

#### 2. **User Role Setup**

-   ✅ Admin user: `admin@parkir.com` dengan role `admin`
-   ✅ Petugas user: `petugas@parkir.com` dengan role `petugas`

#### 3. **Middleware Configuration**

```php
// Route yang diperbaiki di routes/web.php
Route::middleware('role:admin,petugas')->group(function () {
    Route::get('/parking', [ParkingController::class, 'index'])->name('parking.index');
    Route::get('/parking/create', [ParkingController::class, 'create'])->name('parking.create');
    Route::post('/parking', [ParkingController::class, 'store'])->name('parking.store');
    Route::get('/parking/{parking}', [ParkingController::class, 'show'])->name('parking.show');
    Route::get('/parking/{parking}/print', [ParkingController::class, 'printTicket'])->name('parking.print');
});
```

#### 4. **RoleMiddleware Logic**

```php
// app/Http/Middleware/RoleMiddleware.php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if (!in_array($user->role, $roles)) {
        abort(403, 'Unauthorized. Anda tidak memiliki akses ke halaman ini.');
    }

    return $next($request);
}
```

### 🧪 Testing Steps:

#### 1. **Login sebagai Admin**

```
Email: admin@parkir.com
Password: password
```

#### 2. **Login sebagai Petugas**

```
Email: petugas@parkir.com
Password: password
```

#### 3. **Test URL Debug**

```
http://localhost:8000/debug
```

#### 4. **Test Access Routes**

-   `/parking` - List transaksi parkir
-   `/parking/create` - Form create transaksi
-   `/dashboard` - Dashboard utama

### 🔍 Verification Commands:

#### Check Users in Database:

```bash
cd "d:\laragon\www\mdparkir"
php -r "
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
\$users = \App\Models\User::all(['id', 'name', 'email', 'role']);
foreach(\$users as \$user) {
    echo \$user->id . ' - ' . \$user->name . ' (' . \$user->email . ') - Role: ' . \$user->role . PHP_EOL;
}
"
```

#### Clear Cache:

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### 🎯 Expected Results:

1. **Admin user** dapat mengakses:

    - ✅ Dashboard
    - ✅ Parking List
    - ✅ Create Parking
    - ✅ Admin-only features (Reports, Vehicle Types)

2. **Petugas user** dapat mengakses:

    - ✅ Dashboard
    - ✅ Parking List
    - ✅ Create Parking
    - ❌ Admin-only features

3. **Non-authenticated users**:
    - ❌ Redirect to login
    - ❌ No access to protected routes

### 🚨 Common Issues & Fixes:

#### Issue 1: "Column 'role' not found"

**Fix:** Run migration to add role column:

```bash
php artisan make:migration add_role_to_users_table
# Edit migration file, then:
php artisan migrate
```

#### Issue 2: "Users have NULL role"

**Fix:** Update existing users:

```bash
php setup_users.php
```

#### Issue 3: "403 Forbidden"

**Fix:** Check middleware and routes:

```bash
php artisan route:list | grep parking
```

#### Issue 4: "Middleware not working"

**Fix:** Ensure middleware is registered in bootstrap/app.php:

```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

### 📋 Quick Checklist:

-   [x] Users memiliki role yang benar (`admin` atau `petugas`)
-   [x] Middleware `RoleMiddleware` terdaftar dengan alias `role`
-   [x] Routes parking menggunakan middleware `role:admin,petugas`
-   [x] Database table `users` memiliki kolom `role`
-   [x] Cache sudah di-clear setelah perubahan
-   [x] User sudah logout/login ulang

### 🎉 Success Indicators:

1. **Login berhasil** dengan admin/petugas account
2. **Access granted** ke `/parking/create`
3. **No 403 errors** saat mengakses parking routes
4. **Debug page** (`/debug`) menampilkan permissions yang benar

---

**Status: ✅ RESOLVED**

-   Admin dan petugas sekarang bisa mengakses semua parking features
-   Role-based access control berfungsi dengan benar
-   Testing dapat dilakukan melalui debug page
