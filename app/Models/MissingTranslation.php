<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissingTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['source', 'serial_number', 'language', 'status', 'sent_at', 'received_at'];

    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class, 'serial_number', 'name');
    }

    public function getFlagCodeAttribute()
    {
        $text = $this->attributes['language'];
        switch ($text) {
            case 'gr':
                $text = 'el';
                break;

            case 'en':
                $text = 'gb';
                break;

            default:
                # code...
                break;
        }
        return $text;
    }

    /*!
    Riporta l'elenco, raggruppato per lingua, di tutte le traduzioni che devono essere ancora inviate a Intradoc
    */
    public static function pending()
    {
        $missings = MissingTranslation::where('status', 'pending')
            ->get()
            ->groupBy('language');

        return $missings;
    }
}
