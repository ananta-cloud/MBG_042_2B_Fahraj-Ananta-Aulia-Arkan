<?php

namespace App\Http\Controllers\Gudang;

use App\Models\Bahan_Baku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BahanBakuController
{
    // Display data bahan baku
    public function index()
    {
        $bahan_baku = Bahan_Baku::orderBy('id', 'asc')->paginate(10);
        return view('gudang.bahan_baku.index', compact('bahan_baku'));
    }

    // Create data bahan baku
    public function create()
    {
        return view('gudang.bahan_baku.create');
    }

    public function show($id)
    {
        // Cari bahan baku termasuk yang sudah di-soft delete
        $bahan = Bahan_Baku::withTrashed()->find($id);

        // Jika tidak ditemukan sama sekali di database
        if (!$bahan) {
            abort(404, 'Data bahan baku dengan ID ini TIDAK DITEMUKAN sama sekali di database.');
        }

        // Jika ditemukan tapi sudah di-soft delete
        if ($bahan->trashed()) {
            return "<h3>Status Bahan Baku Ditemukan (Namun Sudah Dihapus)</h3>"
                 . "<p>Data untuk '<strong>" . e($bahan->nama) . "</strong>' dengan ID <strong>" . $id . "</strong> ada di database, tetapi telah dihapus pada tanggal " . $bahan->deleted_at->toDateTimeString() . ".</p>"
                 . "<p>Inilah sebabnya Anda mendapatkan error 404. Laravel secara default tidak akan menampilkan data yang sudah di-soft delete.</p>"
                 . "<hr><a href='" . route('gudang.bahan_baku.index') . "'>Kembali ke Daftar Bahan Baku</a>";
        }

        // Jika ditemukan dan aktif (seharusnya ini tidak akan terjadi jika Anda melihat 404)
        return "<h3>Status Bahan Baku Ditemukan (Aktif)</h3>"
             . "<p>Data untuk '" . e($bahan->nama) . "' dengan ID " . $id . " ditemukan dan aktif.</p>"
             . "<p>Jika Anda masih melihat error 404 di halaman lain, coba jalankan perintah <code>php artisan route:clear</code> untuk membersihkan cache.</p>"
             . "<hr><a href='" . route('gudang.bahan_baku.index') . "'>Kembali ke Daftar Bahan Baku</a>";
    }

    // Simpan data bahan baku
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $data_insert = $request->validate([
            'nama' => 'required|string|max:120|unique:bahan_baku,nama',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'created_at' => Carbon::now(),
        ]);

        // 2. Menentukan status secara otomatis
        $jumlah = 'jumlah';
        $status = 'tersedia';
        $tanggalKadaluarsa = Carbon::parse($data_insert['tanggal_kadaluarsa']);

        if ($tanggalKadaluarsa->isPast()) {
            $status = 'kadaluarsa';
        } elseif (Carbon::now()->diffInDays($tanggalKadaluarsa, false) <= 3 && $jumlah > 0) {
            $status = 'segera kadaluarsa';
        }

        // Jika jumlah 0 atau kurang, status 'habis'
        if ($data_insert['jumlah'] < 1 && $status === 'tersedia') {
            $status = 'habis';
        }

        // 3. Menambahkan status ke dalam data yang akan disimpan
        $data_store = $data_insert;
        $data_store['status'] = $status;
        Bahan_Baku::create($data_store);

        return redirect()->route('gudang.bahan_baku.index')
            ->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    // Edit data bahan baku
    public function edit(Bahan_Baku $bahan_baku)
    {
        return view('gudang.bahan_baku.edit', compact('bahan_baku'));
    }

    // Update data bahan baku
    public function update(Request $request, Bahan_Baku $bahan_baku)
    {
        // 1. Validasi data yang masuk
        $data_update = $request->validate(
            [
                'nama' => [
                    'required',
                    'string',
                    'max:120',
                    Rule::unique('bahan_baku')->ignore($bahan_baku->id),
                ],
                'kategori' => 'required|string|max:60',
                'jumlah' => 'required|integer|min:1',
                'satuan' => 'required|string|max:20',
                'tanggal_masuk' => 'required|date',
                'tanggal_kadaluarsa' => [
                    'required',
                    'date',
                    'after:' . Carbon::parse($request->input('tanggal_masuk'))->addDays(2)->format('Y-m-d')
                ],
                'created_at' => Carbon::now(),
            ],
            [
                'tanggal_kadaluarsa.after' => 'Tanggal kadaluarsa harus minimal 3 hari setelah tanggal masuk.'
            ]

        );

        // 2. Menentukan kembali status berdasarkan data yang baru
        $jumlah = 'jumlah';
        $status = 'tersedia';
        $tanggalKadaluarsa = Carbon::parse($data_update['tanggal_kadaluarsa']);

        if ($tanggalKadaluarsa->isPast()) {
            $status = 'kadaluarsa';
        } elseif (Carbon::now()->diffInDays($tanggalKadaluarsa, false) <= 3 && $jumlah > 0) {
            $status = 'segera_kadaluarsa';
        }

        // Jika jumlah 0 atau kurang, status 'habis'
        if ($data_update['jumlah'] < 1 && $status === 'tersedia') {
            $status = 'habis';
        }

        // 3. Menambahkan status ke data yang akan di-update
        $data_terupdate = $data_update;
        $data_terupdate['status'] = $status;

        // 4. Melakukan update
        $bahan_baku->update($data_terupdate);

        return redirect()->route('gudang.bahan_baku.index')
            ->with('success', 'Bahan Baku berhasil diperbarui.');
    }

    // Hapus data bahan baku
    public function destroy(Bahan_Baku $bahan_baku)
    {
        // Cek apakah bahan ini ada di permintaan yang statusnya masih 'menunggu'
        $permintaanAktif = $bahan_baku->permintaanDetail()
            ->whereHas('permintaan', function ($query) {
                $query->where('status', 'menunggu');
            })->exists();

        if ($permintaanAktif) {
            // Jika ada, batalkan penghapusan dan berikan pesan error
            return redirect()->route('gudang.bahan_baku.index')
                             ->with('error', "Bahan '{$bahan_baku->nama}' tidak dapat dihapus karena sedang ada dalam permintaan yang menunggu persetujuan.");
        }

        // Jika aman, lakukan soft delete
        $bahan_baku->delete();

        return redirect()->route('gudang.bahan_baku.index')
                         ->with('success', "Bahan Baku '{$bahan_baku->nama}' berhasil dihapus.");
    }
}
