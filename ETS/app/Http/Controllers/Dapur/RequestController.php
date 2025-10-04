<?php

namespace App\Http\Controllers\Dapur;

use App\Http\Controllers\Controller;
use App\Models\Bahan_Baku;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RequestController
{
    /**
     * Menampilkan riwayat permintaan dari user yang sedang login.
     */
    public function index()
    {
        $permintaan = Permintaan::where('pemohon_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('dapur.request_bahan_baku.index', compact('permintaan'));
    }

    /**
     * Menampilkan form untuk membuat permintaan baru.
     */
    public function create()
    {
        // Ambil semua bahan baku yang tersedia untuk ditampilkan di dropdown
        $bahan_baku = Bahan_Baku::where('status', '!=', 'habis')->orderBy('nama')->get();
        return view('dapur.request_bahan_baku.create', compact('bahan_baku'));
    }

    /**
     * Menyimpan permintaan baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_masak' => 'required|date|after_or_equal:today',
            'menu_makan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan_id' => 'required|array|min:1',
            'bahan_id.*' => ['required', Rule::exists('bahan_baku', 'id')],
            'jumlah_diminta' => 'required|array|min:1',
            'jumlah_diminta.*' => 'required|integer|min:1',
        ], [
            'bahan_id.required' => 'Harap tambahkan minimal satu bahan baku.',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 1. Buat data permintaan utama
                $permintaan = Permintaan::create([
                    'pemohon_id' => Auth::id(),
                    'tgl_masak' => $validated['tgl_masak'],
                    'menu_makan' => $validated['menu_makan'],
                    'jumlah_porsi' => $validated['jumlah_porsi'],
                    'status' => 'menunggu', // Status default
                ]);

                // 2. Simpan detail bahan baku
                foreach ($validated['bahan_id'] as $index => $bahanId) {
                    $permintaan->detail()->create([
                        'bahan_id' => $bahanId,
                        'jumlah_diminta' => $validated['jumlah_diminta'][$index],
                    ]);
                }
            });
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal membuat permintaan: ' . $th->getMessage())->withInput();
        }

        return redirect()->route('dapur.request_bahan_baku.index')->with('success', 'Permintaan bahan baku berhasil dibuat.');
    }
}

