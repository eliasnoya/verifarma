<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Src\Context\Pharmacy\Domain\Pharmacy;
use Illuminate\Support\Str;
use Src\Context\Pharmacy\Domain\Exceptions\AddressValueException;
use Src\Context\Pharmacy\Domain\Exceptions\LocationValueException;
use Src\Context\Pharmacy\Domain\ValueObject\Address;
use Src\Context\Pharmacy\Domain\ValueObject\Coordinates;
use Src\Context\Pharmacy\Domain\ValueObject\Id;
use Src\Context\Pharmacy\Domain\ValueObject\Name;
use Src\Shared\Domain\Exceptions\BlankValueException;

class PharmacyDomainTest extends TestCase
{
    /** @test */
    public function test_pharmacy_invalid_name_throws_exception(): Pharmacy
    {
        // must fail the first error at Name valueobject
        $this->expectException(BlankValueException::class);
        return new Pharmacy(new Id(Str::uuid()), new Name(""), new Address('Fail', new Coordinates(0, 0)));
    }

    public function test_pharmacy_invalid_address_throws_exception(): Pharmacy
    {
        $this->expectException(AddressValueException::class);
        return new Pharmacy(new Id(Str::uuid()), new Name("Pharmacy Name"), new Address("", new Coordinates(0, 0)));
    }

    public function test_pharmacy_invalid_cordinates_throws_exception(): Pharmacy
    {
        $this->expectException(LocationValueException::class);
        return new Pharmacy(new Id(Str::uuid()), new Name("Pharmacy Name"), new Address("Street 123", new Coordinates(-91, 181)));
    }

    public function test_pharmacy_instance_ok()
    {
        try {
            $response = new Pharmacy(new Id(Str::uuid()), new Name("Pharmacy Name"), new Address("Street 123", new Coordinates(0, 0)));
            $this->assertInstanceOf(Pharmacy::class,  $response);
        } catch (\Throwable $th) {
            $this->fail($th->getMessage());
        }
    }
}
