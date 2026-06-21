<?php

namespace App\UseCases\Home;

use App\Contracts\HomeRepositoryInterface;
use App\Enums\StatusEventsEnum;
use App\Models\Competitor;
use App\Models\CompetitorData;
use App\Models\Event;

class HomePage
{
    public function __construct(private HomeRepositoryInterface $homeRepository){}

    public function execute() : array
    {
        $estatisticas = [
            'kmPercorridos' => $this->homeRepository->getTotalKm(),
            'corredores' => $this->homeRepository->getTotalCompetitors(),
            'eventosRealizados' => $this->homeRepository->getFinishedEventsCount()
        ];

        return [
            'estatisticas' => $estatisticas,
            'proximoEventos' => $this->homeRepository->getNextEvents()
        ];
    }
}