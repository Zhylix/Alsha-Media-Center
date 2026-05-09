# TODO - Sparepart Management

## Step 1 (Repo investigation)
- [x] Cari struktur existing terkait spareparts (routing/model/migration/view)
- [x] Putuskan membuat fitur dari nol karena folder view spareparts tidak ada di filesystem

## Step 2 (Database)
- [ ] Buat migration `sparepart_categories`
- [ ] Buat migration `spareparts`

## Step 3 (Models)
- [ ] Buat `SparepartCategory` model + relasi
- [ ] Buat `Sparepart` model + relasi

## Step 4 (Admin CRUD)
- [ ] Buat `AdminSparepartController`
- [ ] Tambah routes admin resource `spareparts`
- [ ] Buat views admin index/create/edit

## Step 5 (Public UI + Filtering)
- [ ] Update `services/show.blade.php` untuk menampilkan sparepart sesuai service category
- [ ] Buat UI selectable marketplace-like + status active/selected
- [ ] Tambahkan JS realtime kalkulasi total (jasa + sparepart)

## Step 6 (Integration & Validation)
- [ ] Pastikan spareparts hanya tampil saat `is_active`
- [ ] Pastikan filter berdasarkan `service.category`
- [ ] Validasi stok minimal >= 0 saat create/update

## Step 7 (Run & Test)
- [ ] `php artisan migrate`
- [ ] `npm run dev` (jika perlu asset build)
- [ ] Manual test di UI

