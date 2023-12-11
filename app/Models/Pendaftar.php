<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama','email','alamat','no_telp','berkas','foto','user','perusahaan','status'
    ];
}
