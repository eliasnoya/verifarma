<?php

namespace Src\Shared\Infrastructure;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SharedController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
