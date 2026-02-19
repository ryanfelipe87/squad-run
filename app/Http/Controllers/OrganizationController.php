<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRegisterRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use DomainException;
use Exception;
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

    public function createOrganization(OrganizationRegisterRequest $request){
        $data = $request->validated();
        $response = $this->organizationService->createOrganization($data);
        return response()->json($response, 201);
    }

    public function updateOrganization($id, Request $request){
        try{
            $organization = Organization::findOrFail($id);
            $this->authorize('update', $organization);
            $response = $this->organizationService->updateOrganization($id, $request->all());
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while updating the organization.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }

    public function deleteOrganization($id){
        try{
            $organization = Organization::findOrFail($id);
            $this->authorize('delete', $organization);
            $response = $this->organizationService->deleteOrganization($id);
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        } catch(DomainException $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch(Exception $e){
            $idError = logErro($e->getMessage());
            return response()->json([
                'message' => 'An error occurred while deleting the organization.',
                'error_id' => $idError
            ], 500);
        }

        return response()->json($response, 200);
    }
}
