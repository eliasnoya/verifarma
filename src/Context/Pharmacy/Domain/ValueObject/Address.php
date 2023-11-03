<?php

namespace Src\Context\Pharmacy\Domain\ValueObject;

use Src\Context\Pharmacy\Domain\Exceptions\AddressValueException;
use Src\Shared\Domain\Contracts\InterfaceValueObject;

final class Address implements InterfaceValueObject
{
    /**
     * @param  Coordinates  $coordinates : another ObjectValue dependency
     */
    public function __construct(private string $address, private Coordinates $coordinates)
    {
        $this->validate();
    }

    /**
     * Example Validation
     * 1) Not empty address line
     * 2) if the address line has two words at list: StreetName StreetNumber format
     *
     * @return void
     */
    public function validate()
    {
        $isEmpty = empty(trim($this->address));
        $parts = explode(' ', $this->address);

        if ($isEmpty || count($parts) < 2) {
            throw new AddressValueException();
        }
    }

    /**
     * @return array : [description, latitude, longitude]
     */
    public function value(): array
    {
        return [trim($this->address), ...$this->coordinates->value()];
    }
}
