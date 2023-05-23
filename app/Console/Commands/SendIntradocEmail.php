<?php

namespace App\Console\Commands;

use App\Models\MissingTranslation;
use Illuminate\Console\Command;

class SendIntradocEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'intradoc-email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send missing translations to Intradoc via email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('- Start job intradoc-email:send');

        $missings = MissingTranslation::pending();

        if ( $missings->count() == 0 ) return;

        // TODO: Inviare la mail a Intradoc
        foreach ($missings['es'] as $missingTranslation) {
            $missingTranslation->update([
                'status' => 'waiting',
                'sent_at' => now(),
            ]);
        }

        $missings = MissingTranslation::limit(100)->get();
        foreach ($missings as $missingTranslation) {
            $missingTranslation->update([
                'status' => 'translated',
                'received_at' => now(),
            ]);
        }

    }
}
