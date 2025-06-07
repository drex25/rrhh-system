<?php

namespace App\Mail;

use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShortlistedWithCalendly extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $calendlyLink;

    public function __construct(Candidate $candidate, string $calendlyLink)
    {
        $this->candidate = $candidate;
        $this->calendlyLink = $calendlyLink;
    }

    public function build()
    {
        return $this->subject('¡Queremos conocerte! - ' . config('app.name'))
                    ->markdown('emails.shortlisted-with-calendly');
    }
} 