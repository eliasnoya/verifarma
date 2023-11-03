<?php

namespace Src\Context\Pharmacy\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $pharmacy_id
 * @property string $address
 * @property float $latitude
 * @property float $longitude
 */
class PharmacyAddress extends Model
{
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
