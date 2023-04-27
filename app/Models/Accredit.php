<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accredit extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'customer_email',
        'customer_company',
        'customer_id',
        'customer_name',
        'pin',
        'machine',
        'format',
        'duration',
        'token',
        'language',
        'level',
        'downloaded_at',
        'display_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
