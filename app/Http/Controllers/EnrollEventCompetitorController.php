<?php

namespace App\Http\Controllers;

use App\DTOs\SubscribeEventDTO;
use App\Models\Competitor;
use App\Models\Event;
use App\Services\EnrollEventCompetitorService;
use App\UseCases\Subscribes\SubscribeCompetitor;
use DomainException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class EnrollEventCompetitorController extends Controller
{
    public function __construct(
        private SubscribeCompetitor $subscribeCompetitor
    ){}

    public function subscribeEvent(Event $event){
        try{
            $this->authorize('subscribeEvent', $event);
            $dto = new SubscribeEventDTO(
                eventId: $event->id,
                userId: auth()->id()
            );

            $registration = $this->subscribeCompetitor->execute($dto);

            return response()->json([
                'message' => 'Inscrição realizada com sucesso',
                'data' => $registration
            ], 201);
        }catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }catch(AuthorizationException $e){
            return response()->json([
                'message' => 'Não autorizado.'
            ], 403);
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'Erro interno.',
                'error_id' => $idError
            ], 500);
        }
    }
}
