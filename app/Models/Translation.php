<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'serial_number',
        'language',
        'status',
        'context',
        'comment',
        'sent_at',
        'received_at',
        'translation',
        'verified',
    ];

    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class, 'serial_number', 'name');
    }

    public function getFlagCodeAttribute()
    {
        $text = $this->attributes['language'];
        switch ($text) {
            case 'el':
                $text = 'gr';
                break;

            case 'en':
                $text = 'gb';
                break;

            case 'uk':
                $text = 'ua';
                break;

            default:
                # code...
                break;
        }
        return $text;
    }
}
