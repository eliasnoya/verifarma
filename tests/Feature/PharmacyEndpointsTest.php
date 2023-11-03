<?php

namespace Tests\Feature;

use Src\Context\Pharmacy\Infrastructure\Eloquent\Pharmacy as PharmacyModel;
use Src\Context\Pharmacy\Infrastructure\Eloquent\PharmacyAddress;
use Tests\TestCase;

class PharmacyEndpointsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_create_pharmacy_with_no_data_must_fail(): void
    {
        $response = $this->post('/farmacia', []);
        $response->assertStatus(500);
    }

    public function test_create_pharmacy_ok(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->post('/farmacia', [
            "name" => "FakeTestFarmacy_2023",
            "addresses" => [
                [
                    "address" => "Av. Caseros 2979",
                    "latitude" => "-34.6425577",
                    "longitude" => "-58.4143663"
                ]
            ]
        ]);

        // Dev context but delete after anyway
        $oldTestCase = PharmacyModel::where('name', "FakeTestFarmacy_2023")->first();
        if ($oldTestCase) {
            PharmacyAddress::where('pharmacy_id', $oldTestCase->id)->delete();
            $oldTestCase->delete();
        }

        $response->assertSuccessful();
    }

    public function test_nearby_feature_respond_error(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get('/farmacia'); // search without data
        $response->assertInternalServerError();
    }

    public function test_nearby_feature_respond_ok(): void
    {
        /** @var \Illuminate\Testing\TestResponse $response */
        $response = $this->get('/farmacia?latitude=-34.646478&longitude=-58.4026048');
        $response->assertSuccessful();
    }
}
