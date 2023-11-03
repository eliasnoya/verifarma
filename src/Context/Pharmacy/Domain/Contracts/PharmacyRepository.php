<?php

namespace Src\Context\Pharmacy\Domain\Contracts;

use Src\Context\Pharmacy\Domain\Pharmacy;
use Src\Context\Pharmacy\Domain\ValueObject\Coordinates;

interface PharmacyRepository
{
    /**
     * Get pharmacy entity by ID value
     */
    public function findId(string $id): Pharmacy;

    /**
     * Store the pharmacy entity
     *
     * @return string : id
     */
    public function store(Pharmacy $pharmacy): string;

    /**
     * Find near pharmacies
     */
    public function findByCoordinates(Coordinates $coordinates, float $kmRadius = 1.5): array;
}
