<?php

namespace Src\Shared\Domain\Exceptions;

use Exception;
use Throwable;

class ValueObjectException extends Exception
{
    public function __construct(string $message, int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
