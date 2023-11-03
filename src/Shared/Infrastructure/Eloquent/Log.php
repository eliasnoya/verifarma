<?php

namespace Src\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $path
 * @property string $method
 * @property string $request_body
 * @property string $request_headers
 * @property int $response_status
 * @property string $response_body
 * @property string $response_headers
 * @property string $ip
 */
class Log extends Model
{
}
