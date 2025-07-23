// EXPO SNACK SETUP GUIDE
// Copy all files below into your Expo Snack project

/*
=== STEP 1: CREATE NEW EXPO SNACK ===
1. Go to https://snack.expo.dev
2. Create new project
3. Delete default App.js content

=== STEP 2: COPY FILES ===
Copy these files in order:

1. package.json (dependencies)
2. App.js (main app)
3. context/AuthContext.js
4. context/ParkingContext.js  
5. services/ApiService.js
6. screens/LoginScreen.js
7. screens/HomeScreen.js
8. screens/ParkingEntryScreen.js
9. screens/HistoryScreen.js
10. screens/SettingsScreen.js

=== STEP 3: UPDATE API URL ===
Edit services/ApiService.js:
- Change localhost to your computer's IP address
- Example: http://192.168.1.100:8000/api/v1

=== STEP 4: START LARAVEL SERVER ===
Run in terminal:
cd d:\laragon\www\mdparkir
php artisan serve --host=0.0.0.0 --port=8000

=== STEP 5: TEST APP ===
Login with:
Email: admin@parkir.com
Password: password
*/

// === FILE: package.json ===
const packageJson = {
  "main": "node_modules/expo/AppEntry.js",
  "scripts": {
    "start": "expo start",
    "android": "expo start --android", 
    "ios": "expo start --ios",
    "web": "expo start --web"
  },
  "dependencies": {
    "expo": "~49.0.0",
    "expo-status-bar": "~1.6.0",
    "react": "18.2.0",
    "react-native": "0.72.6",
    "react-native-paper": "^5.10.0",
    "react-native-vector-icons": "^10.0.0",
    "@react-navigation/native": "^6.1.0",
    "@react-navigation/bottom-tabs": "^6.5.0", 
    "@react-navigation/stack": "^6.3.0",
    "react-native-screens": "~3.22.0",
    "react-native-safe-area-context": "4.6.3",
    "react-native-gesture-handler": "~2.12.0",
    "@react-native-async-storage/async-storage": "1.18.2",
    "axios": "^1.5.0",
    "react-native-reanimated": "~3.3.0"
  },
  "devDependencies": {
    "@babel/core": "^7.20.0"
  },
  "private": true,
  "name": "parking-system-mobile",
  "version": "1.0.0"
};

// Copy package.json content above to Expo Snack package.json

export default null;
