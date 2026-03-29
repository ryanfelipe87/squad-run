<?php

namespace App\Console\Commands;

use App\Enums\StatusEventsEnum;
use App\Jobs\SendReminderEmailJob;
use App\Models\Event;
use Illuminate\Console\Command;

class SendEventReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::whereDate('event_date', now()->addDay())->where('status', StatusEventsEnum::PUBLISHED)->get();

        foreach($events as $event){
            foreach($event->registrations as $registration){
                SendReminderEmailJob::dispatch($event, $registration->competitor);
            }
        }
    }
}
