@echo off
REM Quick Setup Script for Mobile App (Windows)

echo 🚗 Parking System Mobile App Setup
echo ==================================

REM Check if Laravel server is running
echo 📡 Checking API server...
curl -s http://localhost:8000/api/v1/health >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Laravel API server is running
) else (
    echo ❌ Laravel API server is not running
    echo Starting Laravel server...
    cd ..
    start /B php artisan serve --host=0.0.0.0 --port=8000
    echo ✅ Laravel server started
)

REM Get local IP address
echo.
echo 🌐 Your local IP address:
for /f "tokens=2 delims=:" %%i in ('ipconfig ^| findstr /i "ipv4"') do (
    for /f "tokens=1" %%j in ("%%i") do (
        if not "%%j"=="127.0.0.1" (
            echo IP Address: %%j
            echo.
            echo 📝 Update ApiService.js with this URL:
            echo const BASE_URL = 'http://%%j:8000/api/v1';
            goto :found
        )
    )
)
:found

echo.
echo 🔗 Expo Snack Setup:
echo 1. Go to https://snack.expo.dev
echo 2. Create new project
echo 3. Copy all files from mobile-app/ folder
echo 4. Update ApiService.js with IP above
echo 5. Test with login: admin@parkir.com / password
echo.
echo ✅ Setup completed!
pause
