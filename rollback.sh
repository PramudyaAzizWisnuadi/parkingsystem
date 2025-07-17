#!/bin/bash

# Rollback Script - Mengembalikan sistem ke kondisi sebelum deployment
# Usage: ./rollback.sh

set -e

echo "🔄 Starting rollback process..."

# 1. Backup current state before rollback
echo "💾 Creating backup of current state..."
BACKUP_DIR="rollback_backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "storage/backups/$BACKUP_DIR"
cp -r storage/app "storage/backups/$BACKUP_DIR/"
cp .env "storage/backups/$BACKUP_DIR/.env.backup" 2>/dev/null || echo "No .env file found"

# 2. Remove deployment-related files
echo "🧹 Removing deployment files..."
rm -f deploy.sh
rm -f .env.production
rm -f DEPLOYMENT-GUIDE.md
rm -f SECURITY-CHECKLIST.md
rm -f DEPLOYMENT-SUMMARY.md
rm -f config/security.php

# 3. Remove deployment console commands
echo "🗑️ Removing deployment commands..."
rm -f app/Console/Commands/BackupCommand.php
rm -f app/Console/Commands/HealthCheckCommand.php

# 4. Remove security middleware
echo "🛡️ Removing security middleware..."
rm -f app/Http/Middleware/SecurityHeaders.php

# 5. Restore original bootstrap/app.php
echo "🔧 Restoring bootstrap/app.php..."
cat > bootstrap/app.php << 'EOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
EOF

# 6. Restore original routes/web.php
echo "🛣️ Restoring routes/web.php..."
cat > routes/web.php << 'EOF'
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketConfigController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ParkingController::class, 'dashboard'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk semua user yang login (admin dan petugas)
    Route::get('/parking', [ParkingController::class, 'index'])->name('parking.index');
    Route::get('/parking/create', [ParkingController::class, 'create'])->name('parking.create');
    Route::post('/parking', [ParkingController::class, 'store'])->name('parking.store');
    Route::get('/parking/{parking}', [ParkingController::class, 'show'])->name('parking.show');
    Route::get('/parking/{parking}/print', [ParkingController::class, 'printTicket'])->name('parking.print');

    // Routes khusus untuk admin
    Route::middleware('role:admin')->group(function () {
        // Vehicle Types Routes
        Route::resource('vehicle-types', VehicleTypeController::class);

        // Reports Routes
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');

        // Ticket Configuration Routes
        Route::get('/ticket-config', [TicketConfigController::class, 'index'])->name('ticket-config.index');
        Route::put('/ticket-config', [TicketConfigController::class, 'update'])->name('ticket-config.update');
    });
});

require __DIR__ . '/auth.php';
EOF

# 7. Clear all caches
echo "🧹 Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 8. Remove deployment-related storage directories
echo "🗂️ Cleaning storage directories..."
rm -rf storage/backups/ 2>/dev/null || echo "No backups directory found"

# 9. Reset to development environment
echo "🔧 Setting up development environment..."
if [ -f ".env.example" ]; then
    cp .env.example .env
else
    cat > .env << 'EOF'
APP_NAME="Sistem Parkir"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

# Konfigurasi Tiket
TICKET_COMPANY_NAME="Sistem Parkir"
TICKET_COMPANY_ADDRESS="Jl. Contoh No. 123"
TICKET_COMPANY_PHONE="(021) 1234567"
TICKET_FOOTER_TEXT="Terima kasih atas kunjungan Anda"
EOF
fi

# 10. Generate new application key
echo "🔑 Generating application key..."
php artisan key:generate

# 11. Run migrations (if needed)
echo "🗄️ Running migrations..."
php artisan migrate --force

# 12. Seed database (if needed)
echo "👤 Seeding database..."
php artisan db:seed --class=UserSeeder --force

echo "✅ Rollback completed successfully!"
echo ""
echo "📋 System has been restored to pre-deployment state:"
echo "  - Deployment files removed"
echo "  - Security middleware removed"
echo "  - Console commands removed"
echo "  - Routes restored"
echo "  - Bootstrap configuration restored"
echo "  - Development environment restored"
echo ""
echo "🔧 Next steps:"
echo "  - Verify application is working: php artisan serve"
echo "  - Check database: php artisan migrate:status"
echo "  - Test login with admin credentials"
echo ""
echo "💾 Backup created at: storage/backups/$BACKUP_DIR"
