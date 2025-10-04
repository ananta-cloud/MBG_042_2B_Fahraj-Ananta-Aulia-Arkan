<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BahanBakuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'nama' => 'Beras Medium', 'kategori' => 'Karbohidrat', 'jumlah' => 500, 'satuan' => 'kg', 'tanggal_kadaluarsa' => '2026-03-01'],
            ['id' => 2, 'nama' => 'Telur Ayam', 'kategori' => 'Protein Hewani', 'jumlah' => 2000, 'satuan' => 'butir', 'tanggal_kadaluarsa' => '2025-10-10'],
            ['id' => 3, 'nama' => 'Daging Ayam Broiler', 'kategori' => 'Protein Hewani', 'jumlah' => 300, 'satuan' => 'kg', 'tanggal_kadaluarsa' => '2025-10-02'],
            ['id' => 4, 'nama' => 'Tahu Putih', 'kategori' => 'Protein Nabati', 'jumlah' => 400, 'satuan' => 'potong', 'tanggal_kadaluarsa' => '2025-10-01'],
            ['id' => 5, 'nama' => 'Tempe', 'kategori' => 'Protein Nabati', 'jumlah' => 350, 'satuan' => 'potong', 'tanggal_kadaluarsa' => '2025-10-03'],
            ['id' => 6, 'nama' => 'Sayur Bayam', 'kategori' => 'Sayuran', 'jumlah' => 150, 'satuan' => 'ikat', 'tanggal_kadaluarsa' => '2025-10-01'],
            ['id' => 7, 'nama' => 'Wortel', 'kategori' => 'Sayuran', 'jumlah' => 100, 'satuan' => 'kg', 'tanggal_kadaluarsa' => '2025-10-15'],
            ['id' => 8, 'nama' => 'Kentang', 'kategori' => 'Karbohidrat', 'jumlah' => 120, 'satuan' => 'kg', 'tanggal_kadaluarsa' => '2025-11-20'],
            ['id' => 9, 'nama' => 'Minyak Goreng Sawit', 'kategori' => 'Bahan Masak', 'jumlah' => 80, 'satuan' => 'liter', 'tanggal_kadaluarsa' => '2026-01-01'],
            ['id' => 10, 'nama' => 'Susu Bubuk Fortifikasi', 'kategori' => 'Protein Hewani', 'jumlah' => 50, 'satuan' => 'kg', 'tanggal_kadaluarsa' => '2025-12-10'],
        ];

        foreach ($data as $item) {
            $kadaluarsa = Carbon::parse($item['tanggal_kadaluarsa']);
            $hariTersisa = Carbon::now()->diffInDays($kadaluarsa, false);

            if ($hariTersisa < 0) {
                $status = 'kadaluarsa';
            } elseif ($hariTersisa <= 4) {
                $status = 'segera_kadaluarsa';
            } else {
                $status = 'tersedia';
            }

            DB::table('bahan_baku')->insert([
                'id' => $item['id'],
                'nama' => $item['nama'],
                'kategori' => $item['kategori'],
                'jumlah' => $item['jumlah'],
                'satuan' => $item['satuan'],
                'tanggal_masuk' => Carbon::now(),
                'tanggal_kadaluarsa' => $kadaluarsa,
                'status' => $status,
                'created_at' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
