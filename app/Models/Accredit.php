<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accredit extends Model
{
    use HasFactory;

    protected $casts = [ 'downloaded_at'=>'datetime'];

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

    public function durationString()
    {
        $days = $this->duration;

        $result = "";
        $years = ($days / 365); // days / 365 days
        $years = floor($years);
        if ($years) {
            $result = $years . (($years > 1) ? ' anni' : ' anno');
        }

        $month = ($days % 365) / 30.5; // I choose 30.5 for Month (30,31) ;)
        $month = floor($month);
        if ($month) {
            $result = $result . ($years ? ' ' : '') . $month . (($month > 1) ? ' mesi' : ' mese');
        }

        $days = ($days % 365) % 30.5;
        if ($days) {
            $result = $result . (($years || $month) ? ' e ' : '') . $days . (($days > 1) ? ' giorni' : ' giorno');
        }

        return $result;
    }

}
