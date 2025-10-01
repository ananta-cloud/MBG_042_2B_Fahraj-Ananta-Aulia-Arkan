<?php

namespace App\Http\Controllers;

use App\Models\Bahan_Baku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BahanBakuController
{

    public function index()
    {
        $bahan_baku = Bahan_Baku::orderBy('id', 'asc')->paginate(10);
        return view('gudang.bahan_baku.index', compact('bahan_baku'));
    }

    public function create()
    {
        return view('gudang.bahan_baku.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:120|unique:bahan_baku,nama',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
        ]);

        // 2. Menentukan status secara otomatis
        $status = 'tersedia';
        $tanggalKadaluarsa = Carbon::parse($validatedData['tanggal_kadaluarsa']);

        if ($tanggalKadaluarsa->isPast()) {
            $status = 'kadaluarsa';
        } elseif (Carbon::now()->diffInDays($tanggalKadaluarsa, false) <= 30) {
            $status = 'segera kadaluarsa';
        }

        // Jika jumlah 0 atau kurang, status 'habis'
        if ($validatedData['jumlah'] < 1 && $status === 'tersedia' || $status === 'segera kadaluarsa' || $status === 'kadaluarsa') {
           $status = 'habis';
        }

        // 3. Menambahkan status ke dalam data yang akan disimpan
        $dataToStore = $validatedData;
        $dataToStore['status'] = $status;


        return redirect()->route('gudang.bahan_baku.index')
                         ->with('success', 'Bahan Baku berhasil ditambahkan.');
    }

    public function edit(Bahan_Baku $bahan_baku)
    {
        return view('gudang.bahan_baku.edit', compact('bahan_baku'));
    }

    public function update(Request $request, Bahan_Baku $bahan_baku)
    {
        // 1. Validasi data yang masuk
        $validatedData = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:120',
                Rule::unique('bahan_baku')->ignore($bahan_baku->id),
            ],
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
        ]);

        // 2. Menentukan kembali status berdasarkan data yang baru
        $status = 'tersedia';
        $tanggalKadaluarsa = Carbon::parse($validatedData['tanggal_kadaluarsa']);

        if ($tanggalKadaluarsa->isPast()) {
            $status = 'kadaluarsa';
        } elseif (Carbon::now()->diffInDays($tanggalKadaluarsa, false) <= 30) {
            $status = 'segera kadaluarsa';
        }

        // Jika jumlah 0 atau kurang, status 'habis'
        if ($validatedData['jumlah'] < 1 && $status === 'tersedia' || $status === 'segera kadaluarsa' || $status === 'kadaluarsa') {
           $status = 'habis';
        }

        // 3. Menambahkan status ke data yang akan di-update
        $dataToUpdate = $validatedData;
        $dataToUpdate['status'] = $status;

        // 4. Melakukan update
        $bahan_baku->update($dataToUpdate);

        return redirect()->route('gudang.bahan_baku.index')
                         ->with('success', 'Bahan Baku berhasil diperbarui.');
    }

    public function destroy(Bahan_Baku $bahan_baku)
    {
        if ($bahan_baku->status === 'kadaluarsa') {
            $bahan_baku->delete();
            return redirect()->route('gudang.bahan_baku.index')
                             ->with('success', 'Bahan Baku yang kadaluarsa berhasil dihapus.');
        }

        // Jika status bukan 'kadaluarsa', kembalikan dengan pesan error
        return redirect()->route('gudang.bahan_baku.index')
                         ->with('error', 'Hanya bahan baku dengan status "kadaluarsa" yang dapat dihapus.');
    }
}
