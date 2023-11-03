<?php

namespace Src\Shared\Infrastructure;

use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler;
use Src\Shared\Domain\Exceptions\ValueObjectException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TypeError;

class SharedExceptionHandler extends Handler
{

    public function register(): void
    {
        // Error on ValueObject validation
        $this->renderable(function (ValueObjectException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'debug' => $e->getTrace()
            ], $e->getCode());
        });

        // TypeError instancing a Service, Repository, etc. 422 Error
        $this->renderable(function (TypeError $e) {
            return response()->json([
                'error' => true,
                'message' => "The request is inprocessable, please check the documentation.",
                'debug' => $e->getTrace()
            ], 422);
        });

        // Route not found or db resource not found record
        $this->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'error' => true,
                'message' => "Not found resource.",
                'debug' => $e->getTrace()
            ], 404);
        });

        $this->renderable(function (UniqueConstraintViolationException $e) {
            return response()->json([
                'error' => true,
                'message' => "The resource already exists",
                'debug' => $e->getTrace()
            ], 400);
        });

        // Query exception
        $this->renderable(function (QueryException $e) {
            return response()->json([
                'error' => true,
                'message' => "We cannot resolve your request at this time, please try again later.",
                'debug' => $e->getTrace()
            ], 404);
        });
    }
}
