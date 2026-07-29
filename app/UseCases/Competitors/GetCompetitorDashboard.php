<?php

namespace App\UseCases\Competitors;

use App\Contracts\CompetitorRepositoryInterface;
use App\Contracts\RegistrationRepositoryInterface;

class GetCompetitorDashboard
{
    public function __construct(
        private CompetitorRepositoryInterface $competitorRepository,
        private RegistrationRepositoryInterface $registrationResitory
    ){}

    public function execute(int $userId) : array
    {
        $competitor = $this->competitorRepository->findByUserId($userId);
        $stats = [
            'total_races' => $this->registrationResitory->countByCompetitor($competitor->id),
            'total_km' => $competitor->competitorData?->total_km ?? 0,
            'best_pace' => $this->calculateBestPace($competitor),
            'podiums' => $this->registrationResitory->countPodiums($competitor->id)
        ];

        return [
            'competitor' => $competitor,
            'stats' => $stats,
            'nextEvent' => $this->registrationResitory->getNextEvent($competitor->id),
            'recentRaces' => $this->registrationResitory->getRecentRaces($competitor->id),
            'paceHistory' => [],
            'certificates' => collect(),
            'unreadNotifications' => auth()->user()->unreadNotifications()->count()
        ];
    }
}

