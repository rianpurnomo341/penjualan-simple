<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Artisan;
class SendTwilioMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $pdfUrl;
    protected $bodyMessage;

    /**
     * Create a new job instance.
     *
     * @param string $to
     * @param string $pdfUrl
     * @param string $bodyMessage
     * @return void
     */
    public function __construct($to, $bodyMessage, $pdfUrl)
    {
        Artisan::call('command:hello', ['message' => 'masuk1']);
        $this->to = $to;
        $this->pdfUrl = $pdfUrl;
        $this->bodyMessage = $bodyMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Twilio configuration
        $twilioSid = env('VITE_TWILIO_SID');
        $twilioToken = env('VITE_TWILIO_TOKEN');
        $twilioFrom = env('VITE_TWILIO_FROM');

        Log::info("Twilio PDF URL: {$this->pdfUrl}");
        // Send PDF via Twilio WhatsApp
        $twilio = new Client($twilioSid, $twilioToken);
        $message = $twilio->messages->create("whatsapp:{$this->to}", [
            'from' => "whatsapp:{$twilioFrom}",
            'body' => $this->bodyMessage,
            'mediaUrl' => [$this->pdfUrl],
        ]);
        // Log the Twilio message SID
        Log::info("Twilio message sent with SID: {$message->sid}");
    }
}
