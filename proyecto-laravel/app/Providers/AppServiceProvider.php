<?php

namespace App\Providers;

use App\Interfaces\IOitmRepository;
use App\Interfaces\IOCRDRepository;
use App\Interfaces\IOIGERepository;
use App\InterfacesForm\IFrm010ConsultaArticulosRepository;
use App\InterfacesForm\IFrm020ConsultaClientesRepository;
use App\InterfacesForm\IFrm012fichaArticuloRepository;
use App\InterfacesForm\IFrm030fichaClienteRepository;
use App\Interfaces\ICRD1Repository;
use App\Interfaces\IOITWRepository;
use App\Interfaces\IOITTRepository;
use App\Interfaces\IITT1Repository;
use App\Interfaces\IIGE1Repository;
use App\Repositories\ITT1Repository;
use App\Repositories\IGE1Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IOitmRepository::class, OitmRepository::class);
        $this->app->bind(IOCRDRepository::class, OCRDRepository::class);
        $this->app->bind(IOIGERepository::class, OIGERepository::class);
        $this->app->bind(IFrm010ConsultaArticulosRepository::class, Frm010ConsultaArticulosRepository::class);
        $this->app->bind(IFrm020ConsultaClientesRepository::class, Frm020ConsultaClientesRepository::class);
        $this->app->bind(IFrm012fichaArticuloRepository::class, Frm012Repository::class);
        $this->app->bind(IFrm030fichaClienteRepository::class, Frm030Repository::class);
        $this->app->bind(ICRD1Repository::class, CRD1Repository::class);
        $this->app->bind(IOITWRepository::class, OITWRepository::class);
        $this->app->bind(IOITTRepository::class, OITTRepository::class);
        $this->app->bind(IITT1Repository::class, ITT1Repository::class);
        $this->app->bind(IIGE1Repository::class, IGE1Repository::class);
    }

    public function boot(): void
    {
        //
    }
}