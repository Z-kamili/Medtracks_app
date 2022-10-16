<?php

namespace App\Providers;

use App\Http\Controllers\Dashboard\Establishment\EsCalendarController;
use App\Interfaces\Admin\AdminRepositoryInterface;
use App\Interfaces\Annonce\AnnonceManagementInterface;
use App\Interfaces\Annonce\Establishment\EsAnnonceManagementInterface;
use App\Repository\Annonce\Establishment\EsAnnonceManagementRepository;
use App\Interfaces\Establishment\ProfilEstablishmentInterface;
use App\Interfaces\Professional\ProfilProfessionalInterface;
use App\Interfaces\Annonce\AnnonceRepositoryInterface;
use App\Interfaces\Annonce\Establishment\ProfilChoiceInterface;
use App\Interfaces\Establishment\CalendarEsInterface;
use App\Interfaces\Professional\CalendarProfessionalInterface;
use App\Repository\Admin\AdminRepository;
use App\Repository\Annonce\AnnonceRepository;
use App\Repository\Annonce\Establishment\ProfilChoiceRepository;
use App\Repository\Annonce\Professional\AnnonceManagementRepository;
use App\Repository\Establishment\EstablishmentRepository;
use App\Repository\Professional\agenda\CalendarProfessionalRepository;
use App\Repository\Establishment\agenda\CalendarEstablishmentRepository;
use App\Repository\Professional\ProfessionalRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProfilEstablishmentInterface::class,EstablishmentRepository::class);
        $this->app->bind(ProfilProfessionalInterface::class,ProfessionalRepository::class);
        $this->app->bind(AdminRepositoryInterface::class,AdminRepository::class);
        $this->app->bind(AnnonceRepositoryInterface::class,AnnonceRepository::class);
        $this->app->bind(AnnonceManagementInterface::class,AnnonceManagementRepository::class);
        $this->app->bind(EsAnnonceManagementInterface::class,EsAnnonceManagementRepository::class);
        $this->app->bind(ProfilChoiceInterface::class,ProfilChoiceRepository::class);
        $this->app->bind(CalendarProfessionalInterface::class,CalendarProfessionalRepository::class);
        $this->app->bind(CalendarEsInterface::class,CalendarEstablishmentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}