<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    use HasFactory;

    public function missingTranslations() {
        return $this->hasMany(MissingTranslation::class, 'serial_number', 'name');
    }

}
