<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaan';

    // Laravel akan otomatis menangani created_at jika ada di skema
    public $timestamps = false;

    protected $fillable = [
        'pemohon_id',
        'tgl_masak',
        'menu_makan',
        'jumlah_porsi',
        'status',
        'created_at',
    ];

    protected $cast = [
        'tgl_masak' => 'date',
        'created_at' => 'date',
    ];

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(PermintaanDetail::class, 'permintaan_id');
    }
}

