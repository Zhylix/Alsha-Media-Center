- [ ] Plan: identify root causes for DB insert errors (`slug` missing, `service_price` cannot be null)
- [x] Fix: update migration `2026_05_11_024619_add_slug_to_spareparts_table.php` to actually add `slug` column
- [x] Verify: `Schema::hasColumn('spareparts','slug')` returns true
- [ ] Fix: ensure `service_price` is provided or has DB default so insert doesn't fail with NOT NULL
- [ ] Run: `php artisan migrate --force` and re-test sparepart create
- [ ] Verify: new sparepart insert succeeds without integrity constraint violations

