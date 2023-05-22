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
