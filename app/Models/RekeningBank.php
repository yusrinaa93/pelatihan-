<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningBank extends Model
{
    protected $table = 'rekening_bank';

    protected $fillable = [
        'user_id',
        'nama_bank',
        'nama_rekening',
        'nomor_rekening',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
