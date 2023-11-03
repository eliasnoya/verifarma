<?php

namespace Src\Context\Pharmacy\Domain\ValueObject;

use Src\Shared\Domain\Contracts\InterfaceValueObject;
use Src\Shared\Domain\Exceptions\BlankValueException;

final class Name implements InterfaceValueObject
{
    public function __construct(private string $name)
    {
        $this->validate();
    }

    /**
     * Validate example
     * Note: In this example we use a SHARED exception for simple blank value error.
     *
     * @return void
     */
    public function validate()
    {
        if (empty(trim($this->name))) {
            throw new BlankValueException('Pharmacy must have a name');
        }
    }

    /**
     * get Id value
     */
    public function value(): string
    {
        return trim($this->name);
    }
}
