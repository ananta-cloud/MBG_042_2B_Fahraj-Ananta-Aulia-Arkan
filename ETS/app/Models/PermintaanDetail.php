<?php

namespace App\Models;
use App\Models\Bahan_Baku;
use App\Models\Permintaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanDetail extends Model
{

    protected $table = 'permintaan_detail';
    protected $primaryKey = 'id';
    

    public $timestamps = false;


    protected $fillable = [
        'permintaan_id',
        'bahan_id',
        'jumlah_diminta',
    ];

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class, 'permintaan_id');
    }

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(Bahan_Baku::class, 'bahan_id');
    }
}
