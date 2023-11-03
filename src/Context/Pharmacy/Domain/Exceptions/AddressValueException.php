<?php

namespace Src\Context\Pharmacy\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\ValueObjectException;
use Throwable;

class AddressValueException extends ValueObjectException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Address must not be empty and should have at least 2 words.', 400, $previous);
    }
}
