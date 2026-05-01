# TODO - Implementasi Perubahan Sistem Pesanan

## Plan of Action:

### 1. Update Navigation - Ubah "Kontak Kami" → "Hubungi Kami"
- [ ] Edit layouts/app.blade.php - Ganti menu "Kontak" menjadi "Hubungi Kami" dan arahkan ke /pesanan

### 2. Update Halaman Pesanan (Order Form)
- [ ] Enhance order.blade.php - Tambah dropdown service yang lebih jelas dengan kategori PC, Laptop, Printer
- [ ] Pastikan order number ditampilkan dengan jelas setelah submit

### 3. Update Halaman Tracking
- [ ] Edit order-track.blade.php - Tampilkan status "Menunggu", "Diterima", "Ditolak" dengan jelas

### 4. Update Kontak (Hubungi Kami Halaman)
- [ ] Keep contact.blade.php untuk informasi toko
- [ ] Tapi tambahkan link ke halaman pesanan di navbar

### 5. Verifikasi Notifikasi
- [ ] Pastikan OrderController mengirim notifikasi ke admin

### 6. Update Halaman Sukses
- [ ] Tambah informasi tracking yang jelas

## Dependent Files:
- resources/views/layouts/app.blade.php
- resources/views/order.blade.php
- resources/views/order-track.blade.php
- resources/views/order-success.blade.php
- resources/views/contact.blade.php (`\home\zephyr\E-commerce`)

## Implementation Progress:
- [ ] Step 1: Update navigation menu
- [ ] Step 2: Update order form
- [ ] Step 3: Update tracking page  
- [ ] Step 4: Add status badges
- [ ] Step 5: Test flow
