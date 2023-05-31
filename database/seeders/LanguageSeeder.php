<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (($handle = fopen(resource_path('language-codes_csv.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $code = $data[0];
                $name = explode(";", $data[1]);
                $name = explode(",", $name[0]);
                if ($code == 'alpha2') continue;

                Language::create([
                    'code' => $code,
                    'name' => strtolower($name[0]),
                ]);
            }
            fclose($handle);
        }
    }
}
