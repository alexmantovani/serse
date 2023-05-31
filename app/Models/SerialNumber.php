<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function translations() {
        return $this->hasMany(Translation::class, 'serial_number', 'name');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'serial_number', 'name');
    }

}
