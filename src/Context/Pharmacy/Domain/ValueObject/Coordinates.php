<?php

namespace Src\Context\Pharmacy\Domain\ValueObject;

use Src\Context\Pharmacy\Domain\Exceptions\LocationValueException;
use Src\Shared\Domain\Contracts\InterfaceValueObject;

final class Coordinates implements InterfaceValueObject
{
    public function __construct(private float $latitude, private float $longitude)
    {
        $this->validate();
    }

    /**
     * check if the geolocation is posible (source Google)
     *
     * @throws LocationValueException
     */
    private function validate(): void
    {
        $latitudeInvalidRange = $this->latitude < -90 || $this->latitude > 90;
        $longitudeInvalidRange = $this->longitude < -180 || $this->longitude > 180;

        if ($latitudeInvalidRange || $longitudeInvalidRange) {
            throw new LocationValueException;
        }
    }

    /**
     * get an array with this format 0 => latitude, 1 => longitud
     * for simple desaggregate with list($latitude, $longitud) = $location->value();
     */
    public function value(): array
    {
        return [$this->latitude, $this->longitude];
    }
}
