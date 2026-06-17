<?php

namespace App\Mail;

use App\Models\RepairRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RepairRequestApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public RepairRequest $repairRequest
    ) {
        $this->repairRequest->loadMissing([
            'customer.user',
            'device',
            'technician.user',
        ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Repair Request Approved - Please Bring Your Device'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.repair-request-approved'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
