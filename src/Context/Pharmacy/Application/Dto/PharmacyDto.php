<?php

namespace Src\Context\Pharmacy\Application\Dto;

use Src\Context\Pharmacy\Domain\Pharmacy;
use Src\Context\Pharmacy\Domain\ValueObject\Address;
use Src\Context\Pharmacy\Domain\ValueObject\Coordinates;
use Src\Context\Pharmacy\Domain\ValueObject\Id;
use Src\Context\Pharmacy\Domain\ValueObject\Name;

class PharmacyDto
{
    public function __construct(private Pharmacy $pharmacy)
    {
    }

    /**
     * gets the domain entity
     */
    public function entity(): Pharmacy
    {
        return $this->pharmacy;
    }

    /**
     * static shortcut for quick construction
     *
     * @throws \Throwable when some valueobject validation fails
     */
    public static function fromEntity(Pharmacy $pharmacy): PharmacyDto
    {
        return new PharmacyDto($pharmacy);
    }

    /**
     * Get DTO instance from primitives
     *
     * @param  Address[]  $addresses
     *
     * @throws \Throwable when some valueobject validation fails
     */
    public static function fromPrimitives(string $id, string $name, array $addresses): PharmacyDto
    {
        // pull first Address
        $fa = array_shift($addresses);

        // First Address ValueObject
        $firstAddress = new Address($fa['address'], new Coordinates($fa['latitude'], $fa['longitude']));

        $pharmacy = new Pharmacy(
            new Id($id),
            new Name($name),
            $firstAddress
        );

        // append the rest of the addresses
        foreach ($addresses as $address) {
            $pharmacy->pushAddress(new Address(
                $address['address'],
                new Coordinates($address['latitude'], $address['longitude'])
            ));
        }

        return new PharmacyDto($pharmacy);
    }

    /**
     * Cast Pharmacy as Array
     */
    public function toArray(): array
    {
        $addresses = [];
        foreach ($this->pharmacy->addresses() as $addr) {
            [$description, $latitude, $longitude] = $addr->value();
            $addresses[] = compact('description', 'latitude', 'longitude');
        }

        return [
            'id' => $this->pharmacy->id()->value(),
            'name' => $this->pharmacy->name()->value(),
            'addresses' => $addresses,
        ];
    }
}
