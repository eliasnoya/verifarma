<?php

namespace Src\Shared\Domain\Exceptions;

use Throwable;

class BlankValueException extends ValueObjectException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('The value must not be empty', 400, $previous);
    }
}
