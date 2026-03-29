<?php

namespace App\Jobs;

use App\Enums\RegistrationStatusEnum;
use App\Models\Competitor;
use App\Models\CompetitorData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCompetitorStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $competitorId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $competitor = Competitor::find($this->competitorId);

        if(!$competitor) return;

        $finished = $competitor->registrations()->where('status', RegistrationStatusEnum::FINISHED)->get();

        $status = [
            'total_km' => $finished->sum('traveled_km'),
            'total_runs' => $finished->count(),
            'best_time' => $finished->min('total_time'),
            'awards_winner' => $finished->where('awards_winner', true)->count()
        ];

        CompetitorData::updateOrCreate(
            ['id_competitor' => $competitor->id],
            $status
        );
    }
}
