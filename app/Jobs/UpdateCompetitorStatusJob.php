<?php

namespace App\Jobs;

use App\Enums\RegistrationStatusEnum;
use App\Mail\EventFinishedUpdateStatusCompetitorMail;
use App\Models\Competitor;
use App\Models\CompetitorData;
use App\Models\Registrations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UpdateCompetitorStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct
    (
        public int $competitorId,
        public int $eventId
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $competitor = Competitor::with('user')->find($this->competitorId);

        if(!$competitor) return;

        $finished = $competitor->registrations()->where('status', RegistrationStatusEnum::FINISHED)->get();

        $status = [
            'total_km' => $finished->sum('traveled_km'),
            'total_runs' => $finished->count(),
            'best_time' => gmdate('H:i:s', $finished->min('total_time')),
            'awards_winner' => $finished->where('position', '<=', 3)->count()
        ];

        CompetitorData::updateOrCreate(
            ['id_competitor' => $competitor->id],
            $status
        );

        $registration = Registrations::with('event')
            ->where('id_competitor', $this->competitorId)
            ->where('id_event', $this->eventId)
            ->first();

        if(!$registration) return;

        $event = $registration->event;

        if(!$competitor->user || !$competitor->user->email) return;

        Mail::to($competitor->user->email)->send(new EventFinishedUpdateStatusCompetitorMail($event, $competitor, $registration));
    }
}
