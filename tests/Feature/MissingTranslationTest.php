<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\MissingTranslation;
use App\Models\SerialNumber;
use Tests\TestCase;

class MissingTranslationTest extends TestCase
{
    public function test_serialNumber_have_right_missing_translations(): void
    {
        $serialNumber = SerialNumber::factory()->create();
        MissingTranslation::factory(3)->create([
            'serial_number' => $serialNumber->name,
        ]);

        $this->assertEquals($serialNumber->missingTranslations->count(), 3);
    }

    public function test_missing_translations_whithout_serialNumber_class(): void
    {
        $missinTranslation = MissingTranslation::factory()->create([
            'serial_number' => "M5200020",
        ]);

        $this->assertNull($missinTranslation->serialNumber);
    }

}
