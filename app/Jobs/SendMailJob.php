<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mail;
    
    /**
     * Create a new job instance.
     */
    public function __construct($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->mail->email)->send($this->mail);
    }
}
