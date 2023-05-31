<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'file',
        'hash',
    ];

    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class, 'serial_number', 'name');
    }


}
