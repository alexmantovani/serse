<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Accredit;

class AccreditCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $accredit;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Accredit $accredit)
    {
        $this->accredit = $accredit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( 'no-reply@easy.meal', 'Pendrive Accredits Staff' )
        ->view( 'emails.accredit' )
        ->subject('Pendrive account...')
        ->with( ['accredit' => $this->accredit] );
    }
}
