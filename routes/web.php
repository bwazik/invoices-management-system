<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Invoices\InvoicesController;
use App\Http\Controllers\Invoices\InvoiceDetailsController;
use App\Http\Controllers\Invoices\InvoicesArchiveController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Reports\ReportsController;

Auth::routes(['register' => false, 'confirm' => false, 'reset' => false]);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest']
    ], function(){
        Auth::routes(['register' => false, 'confirm' => false, 'reset' => false, 'logout' => false]);

        Route::get('/', function () {
            return view('auth.login');
        });
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function(){

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    # Sections
    Route::controller(SectionsController::class)->group(function() {
        Route::group(['prefix' => 'sections'], function () {
            Route::get('/', 'index')->name('sections');
            Route::post('add', 'add')->name('addSection');
            Route::post('edit', 'edit')->name('editSection');
            Route::post('delete', 'delete')->name('deleteSection');
            Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedSections');
        });
    });

    # Products
    Route::controller(ProductsController::class)->group(function() {
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', 'index')->name('products');
            Route::post('add', 'add')->name('addProduct');
            Route::post('edit', 'edit')->name('editProduct');
            Route::post('delete', 'delete')->name('deleteProduct');
            Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedProducts');
        });
    });

    # Invoices
    Route::group(['prefix' => 'invoices'], function () {
        # All Invoices
        Route::controller(InvoicesController::class)->group(function() {
            Route::get('/', 'index')->name('invoices');
            Route::get('/sections/{id}', 'getProducts')->name('getProducts');
            Route::post('add', 'add')->name('addInvoice');
            Route::post('edit', 'edit')->name('editInvoice');
            Route::post('delete', 'deleteInvoice')->name('deleteInvoice');
            Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedInvoices');
            Route::post('change-payment-status', 'changePaymentStatus')->name('changePaymentStatus');
            Route::post('archive', 'archiveInvoice')->name('archiveInvoice');
            Route::post('archive-selected', 'archiveSelected')->name('archiveSelectedInvoices');
            Route::get('{id}/print', 'printInvoice')->name('printInvoice');
            Route::get('export', 'exportInvoices')->name('exportInvoices');

            # Paid Invoices
            Route::get('paid', 'paidInvoices')->name('paidInvoices');
            Route::get('paid/export', 'exportPaidInvoices')->name('exportPaidInvoices');

            # Unpaid Invoices
            Route::get('unpaid', 'unpaidInvoices')->name('unpaidInvoices');
            Route::get('unpaid/export', 'exportUnpaidInvoices')->name('exportUnpaidInvoices');

            # Partial paid Invoices
            Route::get('partial-paid', 'partialPaidInvoices')->name('partialPaidInvoices');
            Route::get('partial-paid/export', 'exportPartialPaidInvoices')->name('exportPartialPaidInvoices');

        });

        # Invoices Archive
        Route::controller(InvoicesArchiveController::class)->group(function() {
            Route::get('archived', 'index')->name('invoicesArchive');
            Route::post('unarchive', 'unarchiveInvoice')->name('unarchiveInvoice');
            Route::post('unarchive-selected', 'unarchiveSelected')->name('unarchiveSelectedInvoices');
            Route::post('archived/delete', 'deleteInvoice')->name('deleteInvoiceArchived');
        });

        # Invoice Details
        Route::controller(InvoiceDetailsController::class)->group(function() {
            Route::get('{id}', 'getInvoiceDetails')->name('getInvoiceDetails');
            Route::get('attachment/show/{number}/{file}', 'show');
            Route::get('attachment/download/{number}/{file}', 'download');
            Route::get('attachment/delete/{id}/{number}/{file}', 'delete');
            Route::post('addAttachment/{invoice_id}', 'addAttachment')->name('addAttachment');
            Route::post('deleteAllAttachments/{invoice_id}', 'deleteAllAttachments')->name('deleteAllAttachments');
        });
    });

    # Users
    Route::controller(UsersController::class)->group(function() {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'index')->name('users');
            Route::post('add', 'add')->name('addUser');
            Route::get('{id}', 'edit')->name('editUser');
            Route::post('update', 'update')->name('updateUser');
            Route::post('delete', 'delete')->name('deleteUser');
            Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedUsers');
        });
    });

    # Roles
    Route::controller(RolesController::class)->group(function() {
        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', 'index')->name('roles');
            Route::post('add', 'add')->name('addRole');
            Route::get('{id}', 'edit')->name('editRole');
            Route::post('update/{id}', 'update')->name('updateRole');
            Route::post('delete', 'delete')->name('deleteRole');
            Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedRoles');
        });
    });

    # Reports
    Route::controller(ReportsController::class)->group(function() {
        Route::group(['prefix' => 'reports'], function () {
            # Invoices Reports
            Route::get('invoices', 'invoicesReports')->name('invoicesReports');
            Route::post('search_by_number', 'numberSearch')->name('numberSearch');
            Route::post('search_by_date', 'dateSearch')->name('dateSearch');

            # Customer Reports
            Route::get('customers', 'customersReports')->name('customersReports');
            Route::post('customers_search', 'customersSearch')->name('customersSearch');
        });
    });

    # Contact
    Route::view('/contact-me', 'contact.index')->name('contact');
});
