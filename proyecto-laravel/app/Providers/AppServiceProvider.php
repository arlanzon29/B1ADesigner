<?php

namespace App\Providers;

use App\Interfaces\IOITMRepository;
use App\Interfaces\IOCRDRepository;
use App\InterfacesForm\IFrm010ConsultaArticulosRepository;
use App\InterfacesForm\IFrm020ConsultaClientesRepository;
use App\InterfacesForm\IFrm012fichaArticuloRepository;
use App\InterfacesForm\IFrm030fichaClienteRepository;
use App\Interfaces\ICRD1Repository;
use App\Interfaces\IOITWRepository;
use App\Interfaces\IOITTRepository;
use App\Interfaces\IITT1Repository;
use App\Repositories\OITMRepository;
use App\Repositories\OCRDRepository;
use App\RepositoriesForm\Frm010ConsultaArticulosRepository;
use App\RepositoriesForm\Frm020ConsultaClientesRepository;
use App\RepositoriesForm\Frm012Repository;
use App\RepositoriesForm\Frm030Repository;
use App\Repositories\CRD1Repository;
use App\Repositories\OITWRepository;
use App\Repositories\OITTRepository;
use App\Repositories\ITT1Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IOITMRepository::class, OITMRepository::class);
        $this->app->bind(IOCRDRepository::class, OCRDRepository::class);
        $this->app->bind(IFrm010ConsultaArticulosRepository::class, Frm010ConsultaArticulosRepository::class);
        $this->app->bind(IFrm020ConsultaClientesRepository::class, Frm020ConsultaClientesRepository::class);
        $this->app->bind(IFrm012fichaArticuloRepository::class, Frm012Repository::class);
        $this->app->bind(IFrm030fichaClienteRepository::class, Frm030Repository::class);
        $this->app->bind(ICRD1Repository::class, CRD1Repository::class);
        $this->app->bind(IOITWRepository::class, OITWRepository::class);
        $this->app->bind(IOITTRepository::class, OITTRepository::class);
        $this->app->bind(IITT1Repository::class, ITT1Repository::class);
    }

    public function boot(): void
    {
        //
    }
}