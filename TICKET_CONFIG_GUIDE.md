# Konfigurasi Tiket Parkir

Sistem konfigurasi tiket parkir memungkinkan Anda untuk mengatur tampilan dan konten tiket parkir sesuai kebutuhan.

## Fitur Konfigurasi

### 1. Informasi Perusahaan

-   **Judul Perusahaan**: Nama aplikasi yang ditampilkan di header tiket
-   **Nama Perusahaan**: Subtitle perusahaan
-   **Alamat**: Alamat perusahaan (optional)
-   **Telepon**: Nomor telepon perusahaan (optional)

### 2. Field Tiket

-   **Nomor Tiket**: Tampilkan/sembunyikan nomor tiket dan customize labelnya
-   **Plat Nomor**: Tampilkan/sembunyikan plat nomor, dengan opsi tampil meski kosong
-   **Jenis Kendaraan**: Tampilkan/sembunyikan jenis kendaraan
-   **Waktu Masuk**: Tampilkan/sembunyikan waktu masuk dengan format custom
-   **Tarif**: Tampilkan/sembunyikan tarif dengan prefix custom

### 3. Footer & Pesan

-   **Pesan Footer**: Pesan ucapan terima kasih yang dapat dikustom
-   **Timestamp Footer**: Timestamp di footer dengan format custom
-   **Label Copy**: Label untuk tiket copy

### 4. Layout & Tampilan

-   **Garis Pemisah**: Kontrol tampilan garis atas, tengah, dan bawah
-   **Style Garis**: Pilihan solid, dashed, atau dotted
-   **Alignment**: Atur posisi header, info, tarif, dan footer (kiri/tengah/kanan)

### 5. Auto Print

-   **Aktifkan/Nonaktifkan**: Toggle auto print setelah submit form
-   **Delay**: Atur waktu tunda sebelum print dialog muncul

## Cara Menggunakan

### Akses Halaman Konfigurasi

1. Login sebagai admin
2. Pilih menu "Konfigurasi Tiket" di sidebar
3. Atau akses langsung: `/ticket-config`

### Mengatur Tampilan Field

1. **Toggle Switch**: Gunakan switch untuk show/hide field
2. **Label Custom**: Isi input di bawah switch untuk mengubah label
3. **Format Tanggal**: Gunakan format PHP (d/m/Y H:i, etc.)
4. **Prefix Tarif**: Tentukan prefix seperti "Rp ", "$", dll.

### Layout dan Style

1. **Garis Pemisah**: Centang/uncheck untuk menampilkan garis
2. **Style Garis**: Pilih dari dropdown (solid/dashed/dotted)
3. **Alignment**: Pilih posisi text dari dropdown

### Auto Print Settings

1. **Toggle Auto Print**: Aktifkan untuk auto print setelah submit
2. **Delay**: Set waktu tunggu dalam milidetik (500-5000ms)

## Environment Variables

Semua konfigurasi disimpan di file `.env` dengan prefix `TICKET_`:

```env
# Company Information
TICKET_COMPANY_TITLE="TIKET PARKIR"
TICKET_COMPANY_NAME="Manajemen Parkir"
TICKET_ADDRESS=""
TICKET_PHONE=""

# Field Display
TICKET_SHOW_COMPANY_TITLE=true
TICKET_SHOW_COMPANY_NAME=true
TICKET_SHOW_COMPANY_ADDRESS=true
TICKET_SHOW_COMPANY_PHONE=true
TICKET_SHOW_TICKET_NUMBER=true
TICKET_SHOW_LICENSE_PLATE=true
TICKET_REQUIRE_LICENSE_PLATE=false
TICKET_SHOW_VEHICLE_TYPE=true
TICKET_SHOW_ENTRY_TIME=true
TICKET_SHOW_AMOUNT=true
TICKET_SHOW_FOOTER_MESSAGE=true
TICKET_SHOW_FOOTER_TIMESTAMP=true
TICKET_SHOW_COPY_LABEL=true

# Labels
TICKET_LABEL_TICKET_NUMBER="No. Tiket"
TICKET_LABEL_LICENSE_PLATE="Plat Nomor"
TICKET_LABEL_VEHICLE_TYPE="Jenis Kendaraan"
TICKET_LABEL_ENTRY_TIME="Waktu Masuk"
TICKET_LABEL_AMOUNT="Tarif"
TICKET_AMOUNT_PREFIX="Rp "

# Messages
TICKET_FOOTER_MESSAGE="Terima kasih atas kunjungan Anda"
TICKET_COPY_LABEL_TEXT="-- COPY --"

# Formats
TICKET_ENTRY_TIME_FORMAT="d/m/Y H:i"
TICKET_FOOTER_TIMESTAMP_FORMAT="d-m-Y H:i:s"

# Layout
TICKET_SHOW_TOP_SEPARATOR=true
TICKET_SHOW_MIDDLE_SEPARATOR=true
TICKET_SHOW_BOTTOM_SEPARATOR=true
TICKET_SEPARATOR_STYLE=dashed
TICKET_HEADER_ALIGNMENT=center
TICKET_INFO_ALIGNMENT=left
TICKET_AMOUNT_ALIGNMENT=center
TICKET_FOOTER_ALIGNMENT=center

# Auto Print
TICKET_AUTO_PRINT=true
TICKET_AUTO_PRINT_DELAY=500
```

## Format Tanggal

Gunakan format PHP standar:

-   `d` = Hari (01-31)
-   `m` = Bulan (01-12)
-   `Y` = Tahun 4 digit (2024)
-   `y` = Tahun 2 digit (24)
-   `H` = Jam 24 format (00-23)
-   `i` = Menit (00-59)
-   `s` = Detik (00-59)

Contoh:

-   `d/m/Y H:i` = 06/08/2025 14:30
-   `d-m-y H:i:s` = 06-08-25 14:30:45
-   `j F Y, H:i` = 6 August 2025, 14:30

## Reset ke Default

Gunakan tombol "Reset Default" untuk mengembalikan semua konfigurasi ke nilai awal.
**Warning**: Semua pengaturan custom akan hilang!

## Preview Tiket

Gunakan tombol "Preview Tiket" untuk melihat hasil konfigurasi pada halaman buat transaksi baru.

## Tips Penggunaan

1. **Mobile Responsive**: Semua konfigurasi otomatis responsive untuk mobile
2. **Print Friendly**: Layout print akan mengikuti konfigurasi yang dipilih
3. **Field Dependencies**: Field yang di-hide otomatis disable inputnya
4. **Auto Save**: Perubahan langsung tersimpan ke file `.env`
5. **Real-time**: Efek konfigurasi langsung terlihat di tiket berikutnya

## Troubleshooting

### Konfigurasi tidak berubah

1. Cek file permission `.env`
2. Clear cache: `php artisan config:clear`
3. Restart web server jika perlu

### Layout rusak

1. Reset ke default
2. Atur ulang satu per satu
3. Pastikan format tanggal valid

### Auto print tidak jalan

1. Cek browser allow popups
2. Pastikan delay tidak terlalu kecil
3. Test di browser yang berbeda
