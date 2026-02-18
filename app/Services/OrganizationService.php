<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationService {

    public function getOrganizationById($id) : array {
        $organization = Organization::find($id);

        $message = $organization ? 'Organization found' : 'Organization not found';

        return [
            'message' => $message,
            'data' => $organization
        ];
    }

    public function getAllOrganizations() : array {
        $organizations = Organization::all();

        return [
            'message' => 'Organizations retrieved successfully',
            'data' => $organizations
        ];
    }

    public function createOrganization(array $data) : array {
        $user = Auth::user();

        $organization = Organization::create([
            'id_user' => $user->id,
            'name' => $data['name'],
            'cnpj' => $data['cnpj'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip_code' => $data['zip_code'],
            'description' => $data['description']
        ]);

        return [
            'message' => 'Organization created successfully',
            'data' => $organization
        ];
    }
}
