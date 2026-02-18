<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRegisterRequest;
use App\Services\OrganizationService;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService){
        $this->organizationService = $organizationService;
    }

    public function getOrganizationById($id){
        $response = $this->organizationService->getOrganizationById($id);
        return response()->json($response);
    }

    public function allOrganizations(){
        $response = $this->organizationService->getAllOrganizations();
        return response()->json($response);
    }

    public function create(OrganizationRegisterRequest $request){
        $data = $request->validated();
        $response = $this->organizationService->createOrganization($data);
        return response()->json($response);
    }
}
