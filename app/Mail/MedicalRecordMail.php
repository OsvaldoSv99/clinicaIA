<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MedicalRecord;

class MedicalRecordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $medicalRecord;
    public $pdfData;

    /**
     * Create a new message instance.
     */
    public function __construct(MedicalRecord $medicalRecord, $pdfData)
    {
        $this->medicalRecord = $medicalRecord;
        $this->pdfData = $pdfData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Receta Médica - Fisioderma',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.medical_record',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $this->pdfData, 'Receta-Fisioderma-' . $this->medicalRecord->visit_date->format('Y-m-d') . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
