<?php

namespace Src\Context\Pharmacy\Infrastructure\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Src\Context\Pharmacy\Application\CreatePharmacyService;
use Src\Context\Pharmacy\Application\FindNearbyPharmacy;
use Src\Context\Pharmacy\Domain\Contracts\PharmacyRepository;
use Src\Context\Pharmacy\Infrastructure\Repositories\DbPharmacyRespository;

class PharmacyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // bind domain to infra implementacion REPOSITORY
        $this->app->bind(PharmacyRepository::class, DbPharmacyRespository::class);

        // bind app layer Create service with injected repository
        $this->app->bind(CreatePharmacyService::class, function (Application $app) {
            $respository = $app->make(PharmacyRepository::class);

            return new CreatePharmacyService($respository);
        });

        // bind app layer Find service with injected repository
        $this->app->bind(FindNearbyPharmacy::class, function (Application $app) {
            $respository = $app->make(PharmacyRepository::class);

            return new FindNearbyPharmacy($respository);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
