<?php

namespace Src\Context\Pharmacy\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;
use Src\Context\Pharmacy\Application\Dto\PharmacyDto;
use Src\Context\Pharmacy\Domain\Contracts\PharmacyRepository as DomainPharmacyRepository;
use Src\Context\Pharmacy\Domain\Pharmacy;
use Src\Context\Pharmacy\Domain\ValueObject\Address;
use Src\Context\Pharmacy\Domain\ValueObject\Coordinates;
use Src\Context\Pharmacy\Infrastructure\Eloquent\Pharmacy as PharmacyModel;
use Src\Context\Pharmacy\Infrastructure\Eloquent\PharmacyAddress as PharmacyAddressModel;

/**
 * Infrastructure implementation of Pharmacy domain repository
 */
class DbPharmacyRespository implements DomainPharmacyRepository
{
    /**
     * Find nearby Pharmacies
     * NOTE: the radius may be in the "future" a ValueObject like type miles/km and multiplier
     */
    public function findByCoordinates(Coordinates $coordinates, float $kmRadius = 1.5): array
    {
        list($latitude, $longitude) = $coordinates->value();

        // collection query is fast without eloquent
        $nearPharmacies = DB::table('pharmacies')->select([
            'pharmacies.id',
            'pharmacies.name',
            'pharmacy_addresses.address',
            'pharmacy_addresses.latitude',
            'pharmacy_addresses.longitude',
            DB::raw("(
                6371 *
                acos(cos(radians($latitude)) *
                cos(radians(latitude)) *
                cos(radians(longitude) -
                radians($longitude)) +
                sin(radians($latitude)) *
                sin(radians(latitude)))
            ) AS km_distance"),
        ])->join('pharmacy_addresses', 'pharmacies.id', 'pharmacy_addresses.pharmacy_id')
            ->having('km_distance', '<=', $kmRadius)
            ->orderBy('km_distance')
            ->get();

        return [
            'pharmacies' => $nearPharmacies->toArray(),
        ];
    }

    /**
     * Find in DB by ID and return a Domain Entity
     *
     * @throws \Throwable : on not found
     */
    public function findId(string $id): Pharmacy
    {
        $model = PharmacyModel::findOrFail($id);

        // from db primitives to domain entity
        return PharmacyDto::fromPrimitives($model->getAttribute('id'), $model->getAttribute('name'), $model->addresses()->get()->toArray())->entity();
    }

    /**
     * Stores on DB the Domain Entity
     *
     * @return string : the ID of the pharmacy
     *
     * @throws \Throwable : when some query fails
     */
    public function store(Pharmacy $pharmacy): string
    {
        // store pharmacy and all his addresses || rollback & throw
        try {
            DB::beginTransaction();

            // from domain entities to primitives and store on database
            $model = new PharmacyModel();
            $model->id = $pharmacy->id()->value();
            $model->name = $pharmacy->name()->value();
            $model->save();

            // at database phamarcy is separated from pharmacy_addresses (binded by FK)

            /** @var Address $address */
            foreach ($pharmacy->addresses() as $address) {
                [$description, $latitude, $longitude] = $address->value();

                $addressModel = new PharmacyAddressModel();
                $addressModel->pharmacy_id = $model->id;
                $addressModel->address = $description;
                $addressModel->latitude = $latitude;
                $addressModel->longitude = $longitude;
                $addressModel->save();
            }

            DB::commit();

            return $model->id;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
