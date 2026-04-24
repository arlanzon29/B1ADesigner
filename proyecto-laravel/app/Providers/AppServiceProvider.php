<?php

namespace App\Providers;

use App\Interfaces\IOitmRepository;
use App\Interfaces\IOCRDRepository;
use App\Interfaces\IFrm010ConsultaArticulosRepository;
use App\Interfaces\IFrm020ConsultaClientesRepository;
use App\Interfaces\IFrm012Repository;
use App\Interfaces\IFrm030Repository;
use App\Interfaces\ICRD1Repository;
use App\Interfaces\IOITWRepository;
use App\Repositories\OitmRepository;
use App\Repositories\OCRDRepository;
use App\Repositories\Frm010ConsultaArticulosRepository;
use App\Repositories\Frm020ConsultaClientesRepository;
use App\Repositories\Frm012Repository;
use App\Repositories\Frm030Repository;
use App\Repositories\CRD1Repository;
use App\Repositories\OITWRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IOitmRepository::class, OitmRepository::class);
        $this->app->bind(IOCRDRepository::class, OCRDRepository::class);
        $this->app->bind(IFrm010ConsultaArticulosRepository::class, Frm010ConsultaArticulosRepository::class);
        $this->app->bind(IFrm020ConsultaClientesRepository::class, Frm020ConsultaClientesRepository::class);
        $this->app->bind(IFrm012Repository::class, Frm012Repository::class);
        $this->app->bind(IFrm030Repository::class, Frm030Repository::class);
        $this->app->bind(ICRD1Repository::class, CRD1Repository::class);
        $this->app->bind(IOITWRepository::class, OITWRepository::class);
    }

    public function boot(): void
    {
        //
    }
}