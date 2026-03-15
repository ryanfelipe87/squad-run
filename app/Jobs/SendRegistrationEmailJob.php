<?php

namespace App\Jobs;

use App\Mail\EventRegistrationMail;
use App\Models\Competitor;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Event $event,
        public Competitor $competitor
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->competitor->user->email)->send(new EventRegistrationMail($this->event, $this->competitor));
    }
}
