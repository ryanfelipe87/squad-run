<?php

namespace App\Services;

use App\Models\Competitor;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CompetitorService {

    public function getAllCompetitors() : array{
        $competitors = Competitor::orderBy('id')->get();
        return $competitors->toArray();
    }

    public function getCompetitorById(int $id) : array {
        $competitor = Competitor::find($id);
        $message = $competitor ? 'Competitor found successfully.' : 'Competitor not found.';
        return [
            'message' => $message,
            'data' => $competitor ? $competitor->toArray() : null
        ];
    }

    public function createCompetitor(array $data) : array {
        $user = Auth::user();

        $competitor = Competitor::create([
            'id_user' => $user->id,
            'cpf' => $data['cpf'],
            'birth_date' => $data['birth_date'],
            'sexo' => $data['sexo'],
            'height' => $data['height'],
            'weight' => $data['weight']
        ]);

        return [
            'message' => 'Competitor created successfully.',
            'data' => $competitor->toArray()
        ];
    }

    public function updateCompetitor(int $id, array $data) : array {
        $competitor = Competitor::find($id);

        if(!$competitor) throw new ModelNotFoundException('Competitor not found.');

        $competitor->update($data);

        return [
            'message' => 'Competitor updated successfully.',
            'data' => $competitor->toArray()
        ];
    }

    public function deleteCompetitor(int $id) : array {
        $competitor = Competitor::find($id);

        if(!$competitor) throw new ModelNotFoundException('Competitor not found.');

        $competitor->delete();

        return [
            'message' => 'Competitor deleted successfully.'
        ];
    }
}
