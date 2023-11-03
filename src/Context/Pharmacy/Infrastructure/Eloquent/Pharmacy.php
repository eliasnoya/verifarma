<?php

namespace Src\Context\Pharmacy\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 *
 * @method static \Src\Context\Pharmacy\Infrastructure\Eloquent\Pharmacy findOrFail($id)
 */
class Pharmacy extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function addresses()
    {
        return $this->hasMany(PharmacyAddress::class);
    }
}
