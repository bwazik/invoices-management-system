<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Interfaces\Products\ProductRepositoryInterface;
use App\Interfaces\Invoices\InvoiceRepositoryInterface;
use App\Interfaces\Invoices\InvoiceDetailsRepositoryInterface;
use App\Interfaces\Invoices\InvoicesArchiveRepositoryInterface;
use App\Interfaces\Users\UserRepositoryInterface;
use App\Interfaces\Roles\RoleRepositoryInterface;
use App\Interfaces\Reports\ReportRepositoryInterface;
use App\Repositories\Sections\SectionRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Invoices\InvoiceRepository;
use App\Repositories\Invoices\InvoiceDetailsRepository;
use App\Repositories\Invoices\InvoicesArchiveRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Reports\ReportRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(InvoiceDetailsRepositoryInterface::class, InvoiceDetailsRepository::class);
        $this->app->bind(InvoicesArchiveRepositoryInterface::class, InvoicesArchiveRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
