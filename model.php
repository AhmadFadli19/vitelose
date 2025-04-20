<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldo';
    protected $fillable = [
        'user_id',
        'saldo',
    ];

    public function Transaction()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi_dana';
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'deskripsi',
        'confirmed'
        // Add any other fields that should be mass assignable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable1111111111111 = [
        'name',
        'email',
        'usertype',
        'password',
        'saldo',
    ];

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function saldo()
    {
        return $this->hasOne(Saldo::class);
    }
}


