<?php

namespace Src\Context\Pharmacy\Domain;

use Src\Context\Pharmacy\Domain\ValueObject\Address;
use Src\Context\Pharmacy\Domain\ValueObject\Id;
use Src\Context\Pharmacy\Domain\ValueObject\Name;

/**
 * Pharmacy aggregate root
 * NOTE FOR REVIEWERS: I decided to use 'address' as a ValueObject because I see it as a description of pharmacy locations.
 * They are inherently immutable; branches may open or close, but the addresses themselves do not change.
 */
class Pharmacy
{
    /** @var Address[] */
    private array $addresses;

    public function __construct(
        private readonly Id $id,
        private readonly Name $name,
        // add first (and maybe only) address as mandatory
        readonly Address $firstAddress,
    ) {
        $this->pushAddress($firstAddress);
    }

    /**
     * Get the value of id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * Get all addresses of this pharmacy
     *
     * @return Address[]
     */
    public function addresses(): array
    {
        return $this->addresses;
    }

    /**
     * add address to the aggregate root
     */
    public function pushAddress(Address $address)
    {
        $this->addresses[] = $address;
    }
}
