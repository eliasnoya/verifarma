<?php

namespace Src\Context\Pharmacy\Domain\Exceptions;

use Src\Shared\Domain\Exceptions\ValueObjectException;
use Throwable;

class LocationValueException extends ValueObjectException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Latitude and/or Longitud out of range', 400, $previous);
    }
}
