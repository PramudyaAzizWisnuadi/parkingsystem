#!/bin/bash
# Quick Setup Script for Mobile App

echo "🚗 Parking System Mobile App Setup"
echo "=================================="

# Check if Laravel server is running
echo "📡 Checking API server..."
if curl -s http://localhost:8000/api/v1/health > /dev/null; then
    echo "✅ Laravel API server is running"
else
    echo "❌ Laravel API server is not running"
    echo "Starting Laravel server..."
    cd ../
    php artisan serve --host=0.0.0.0 --port=8000 &
    echo "✅ Laravel server started"
fi

# Get local IP address
echo ""
echo "🌐 Your local IP address:"
if command -v ip > /dev/null; then
    IP=$(ip route get 1.1.1.1 | head -1 | cut -d' ' -f7)
elif command -v ifconfig > /dev/null; then
    IP=$(ifconfig | grep "inet " | grep -v 127.0.0.1 | head -1 | awk '{print $2}')
else
    echo "Please check your IP address manually"
    IP="YOUR_IP_HERE"
fi

echo "IP Address: $IP"
echo ""
echo "📝 Update ApiService.js with this URL:"
echo "const BASE_URL = 'http://$IP:8000/api/v1';"
echo ""
echo "🔗 Expo Snack Setup:"
echo "1. Go to https://snack.expo.dev"
echo "2. Create new project"
echo "3. Copy all files from mobile-app/ folder"
echo "4. Update ApiService.js with IP above"
echo "5. Test with login: admin@parkir.com / password"
echo ""
echo "✅ Setup completed!"
