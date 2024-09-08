<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SettingRepositoryInterface;
use App\Repositories\SettingRepository;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\OvertimeRepositoryInterface;
use App\Repositories\OvertimeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Daftar layanan untuk pendaftaran.
     *
     * @return void
     */
    public function register()
    {
        // Binding untuk SettingRepository
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        // Binding untuk EmployeeRepository
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);

        // Binding untuk OvertimeRepository
        $this->app->bind(OvertimeRepositoryInterface::class, OvertimeRepository::class);

        // Swagger
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Pendaftaran layanan.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
