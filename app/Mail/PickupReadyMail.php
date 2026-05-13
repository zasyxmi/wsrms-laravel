<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PickupReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Payment $payment
    ) {
        $this->payment->loadMissing([
            'customer.user',
            'invoice.repairRequest.device',
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Repaired Device Is Ready for Pickup'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pickup-ready'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}