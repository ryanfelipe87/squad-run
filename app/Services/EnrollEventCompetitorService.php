<?php

namespace App\Services;

use App\Enums\RegistrationStatusEnum;
use App\Enums\StatusEventsEnum;
use App\Models\Competitor;
use App\Models\Event;
use App\Models\Registrations;
use DomainException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollEventCompetitorService
{
    public function subscribeEvent(Event $event) : array {
        $user = Auth::user();

        $competitor = Competitor::where('id_user', $user->id)->first();
        if(!$competitor) throw new DomainException('User is not a competitor.');

        if($event->status !== StatusEventsEnum::PUBLISHED) throw new DomainException('Event is not available for subscription.');

        if($event->event_date < now()) throw new DomainException('Event date has already passed.');

        if($event->registrations()->where('id_competitor', $competitor->id)->exists()) throw new DomainException('Competitor is already enrolled in this event.');

        return DB::transaction(function () use ($event, $competitor) {

            $eventLocked = Event::where('id', $event->id)
                ->lockForUpdate()
                ->first();

            if ($eventLocked->registrations()->lockForUpdate()->count() >= $eventLocked->vacancies) {
                throw new DomainException('No vacancies available for this event.');
            }

            $registration = $eventLocked->registrations()->create([
                'id_competitor' => $competitor->id,
                'status' => RegistrationStatusEnum::CONFIRMED,
                'total_time' => null,
                'traveled_km' => null
            ]);

            return [
                'message' => 'Competitor successfully enrolled in the event.',
                'registration' => $registration
            ];
        });
    }
}
