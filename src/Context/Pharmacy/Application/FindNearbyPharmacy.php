<?php

namespace Src\Context\Pharmacy\Application;

use Src\Context\Pharmacy\Domain\Contracts\PharmacyRepository;
use Src\Context\Pharmacy\Domain\ValueObject\Coordinates;

/**
 * Service to retrieve near Pharmacies
 */
class FindNearbyPharmacy
{
    /**
     * Inject repository dependency from Domain
     */
    public function __construct(private PharmacyRepository $pharmacyRepository)
    {
    }

    /**
     * Get all pharmacies within the radious (expressed in kilometers) of the coordinates
     */
    public function execute(float $latitude, float $longitude, float $kmRadius = 1.5): array
    {
        return $this->pharmacyRepository->findByCoordinates(new Coordinates($latitude, $longitude), $kmRadius);
    }
}
