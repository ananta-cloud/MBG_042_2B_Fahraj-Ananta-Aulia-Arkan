<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageRequestController
{
    /**
     * Menampilkan daftar permintaan (status 'menunggu').
     */
    public function index()
    {
        $permintaan = Permintaan::where('status', 'menunggu')
            // PERBAIKAN: Tambahkan eager loading untuk detail permintaan dan bahan baku terkait
            // agar bisa ditampilkan langsung di halaman daftar.
            ->with(['pemohon', 'detail.bahanBaku'])
            ->latest()
            ->paginate(10);

        return view('gudang.kelola_request.index', compact('permintaan'));
    }

    /**
     * Mengambil detail permintaan via AJAX.
     */
    public function show(Permintaan $kelola_request)
    {
        // PERBAIKAN: Path relasi diubah menjadi 'detail.bahanBaku'
        // Ini akan memuat relasi 'detail' dari model Permintaan,
        // dan di dalam setiap 'detail', ia akan memuat relasi 'bahanBaku'.
        $kelola_request->load(['pemohon', 'detail.bahanBaku']);

        return response()->json($kelola_request);
    }

    /**
     * Menyetujui permintaan.
     */
    public function approve(Permintaan $kelola_request)
    {
        $kelola_request->load('detail.bahanBaku');
        $tanggalMasak = Carbon::parse($kelola_request->tgl_masak);

        foreach ($kelola_request->detail as $item) {
            $bahan = $item->bahanBaku;

            // Jika bahan tidak ditemukan (mungkin terhapus), otomatis tolak.
            if (!$bahan) {
                $kelola_request->status = 'ditolak';
                $kelola_request->save();
                return redirect()->route('gudang.kelola_request.index')
                                 ->with('error', "Permintaan #{$kelola_request->id} otomatis ditolak. Salah satu bahan yang diminta tidak lagi tersedia.");
            }

            $tanggalKadaluarsa = Carbon::parse($bahan->tanggal_kadaluarsa);

            // Cek jika bahan sudah kadaluarsa ATAU akan kadaluarsa sebelum tanggal masak.
            if ($bahan->status === 'kadaluarsa' || $tanggalKadaluarsa->isBefore($tanggalMasak)) {
                // Jika ya, langsung ubah status permintaan menjadi 'ditolak' dan simpan.
                $kelola_request->status = 'ditolak';
                $kelola_request->save();

                $alasan = ($bahan->status === 'kadaluarsa') ? 'sudah kadaluarsa' : 'akan kadaluarsa sebelum tanggal masak';

                // Kembalikan dengan pesan error yang informatif.
                return redirect()->route('gudang.kelola_request.index')
                                 ->with('error', "Permintaan #{$kelola_request->id} otomatis ditolak karena bahan '{$bahan->nama}' {$alasan}.");
            }
        }

        DB::transaction(function () use ($kelola_request) {
            $kelola_request->status = 'disetujui';
            $kelola_request->save();

            foreach ($kelola_request->detail as $item) {
                $bahan = $item->bahanBaku;
                if ($bahan && $bahan->jumlah >= $item->jumlah_diminta) {
                    $bahan->jumlah -= $item->jumlah_diminta;
                    if ($bahan->jumlah <= 0) {
                        $bahan->status = 'habis';
                    }
                    $bahan->save();
                } else {
                    throw new \Exception("Stok untuk bahan '".($bahan->nama ?? 'Tidak Ditemukan')."' tidak mencukupi.");
                }
            }
        });

        return redirect()->route('gudang.kelola_request.index')->with('success', 'Permintaan berhasil disetujui.');
    }

    /**
     * Menolak permintaan.
     */
    public function reject(Permintaan $kelola_request)
    {
        $kelola_request->status = 'ditolak';
        $kelola_request->save();

        return redirect()->route('gudang.kelola_request.index')->with('success', 'Permintaan telah ditolak.');
    }
}

