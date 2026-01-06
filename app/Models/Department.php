<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI:
    protected $fillable = [
        'name',
    ];

    // Relasi ke Employee (jika sudah Anda buat sebelumnya)
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}