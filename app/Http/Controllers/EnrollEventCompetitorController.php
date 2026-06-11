<?php

namespace App\Http\Controllers;

use App\DTOs\SubscribeEventDTO;
use App\Models\Event;
use App\UseCases\Subscribes\SubscribeCompetitor;
use DomainException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

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

            $this->subscribeCompetitor->execute($dto);

            return redirect()->route('events.show', $event->id)->with('success', 'Inscrição realizada com sucesso!');
        }catch(DomainException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }catch(AuthorizationException $e){
            return redirect()->back()->with('error', 'Você não tem permissão para realizar esta inscrição.');
        }catch(Exception $e){
            $idError = logErro($e->getMessage());
            return redirect()->back()->with('error', 'Erro interno. Código do erro: ' . $idError);
        }
    }
}
