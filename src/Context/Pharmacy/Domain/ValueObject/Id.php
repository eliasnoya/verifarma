<?php

namespace Src\Context\Pharmacy\Domain\ValueObject;

use Src\Shared\Domain\Contracts\InterfaceValueObject;
use TypeError;

final class Id implements InterfaceValueObject
{
    public function __construct(private string $id)
    {
        $this->validate();
    }

    /**
     * Validate unsigned int
     * Note: A generic exception is used in this case because it involves a very simple validation: STRING specific lenght.
     *
     * @return void
     */
    public function validate()
    {
        if (strlen($this->id) !== 36) {
            throw new TypeError('Id must be a 36 char UUID');
        }
    }

    /**
     * get Id value
     */
    public function value(): string
    {
        return $this->id;
    }
}
