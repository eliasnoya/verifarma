<?php

namespace Src\Context\Pharmacy\Application;

use Illuminate\Support\Str;
use Src\Context\Pharmacy\Application\Dto\PharmacyDto;
use Src\Context\Pharmacy\Domain\Contracts\PharmacyRepository;

/**
 * Service for Pharmacy Creation
 */
class CreatePharmacyService
{
    /**
     * Inject repository dependency from Domain
     */
    public function __construct(private PharmacyRepository $pharmacyRepository)
    {
    }

    /**
     * Creates a new Pharmacy and his address/es, the id is UUIDv4 generated
     *
     * @return string : Pharmacy ID
     *
     * @throws \Throwable : when some ValueObject fails or repository action fails
     */
    public function execute(string $name, array $addresses): string
    {
        // Get instance of pharmacy from primitives
        $pharmacyDto = PharmacyDto::fromPrimitives(Str::uuid(), $name, $addresses);

        return $this->pharmacyRepository->store($pharmacyDto->entity());
    }
}
