<?php

namespace Src\Context\Pharmacy\Infrastructure\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Context\Pharmacy\Application\CreatePharmacyService;
use Src\Context\Pharmacy\Application\Dto\PharmacyDto;
use Src\Context\Pharmacy\Application\FindNearbyPharmacy;
use Src\Context\Pharmacy\Domain\Contracts\PharmacyRepository;
use Src\Shared\Infrastructure\SharedController;

/**
 * Presenter for all Pharmacy service in this project.
 * (Please note that I will divide the controllers if the project becomes larger.)
 */
class PharmacyController extends SharedController
{
    /**
     * [GET] /farmacia/{id}
     * Retrieve specific pharmacy
     */
    public function findId(string $id, PharmacyRepository $pharmacyRepository): JsonResponse
    {
        $pharmacy = $pharmacyRepository->findId($id);

        return response()->json(['error' => false] + PharmacyDto::fromEntity($pharmacy)->toArray());
    }

    /**
     * [POST] /farmacia
     * Creates a new Phamacy on database
     *
     * @param  CreatePharmacyService  $service | binding on PharmacyServiceProvider (infrastructure)
     */
    public function create(Request $request, CreatePharmacyService $service): JsonResponse
    {
        $pharmacyId = $service->execute($request->input('name'), $request->input('addresses'));

        return response()->json([
            'error' => false,
            'pharmacy_id' => $pharmacyId,
        ], 201);
    }

    /**
     * [GET] /farmacia?lat=number&lon=number&distance=number<optional>
     * Search farmacies from 1km arround
     */
    public function searchNearbyOnes(Request $request, FindNearbyPharmacy $service): JsonResponse
    {
        $results = $service->execute($request->input('latitude'), $request->input('longitude'), $request->get('distance', 1.5));

        return response()->json(['error' => false] + $results);
    }
}
