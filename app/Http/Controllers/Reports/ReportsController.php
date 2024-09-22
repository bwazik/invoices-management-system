<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Interfaces\Reports\ReportRepositoryInterface;
use App\Http\Requests\Reports\InvoiceDateReportsRequest;
use App\Http\Requests\Reports\InvoiceNumberReportsRequest;
use App\Http\Requests\Reports\CustomersReportsRequest;

class ReportsController extends Controller
{
    protected $report;

    public function __construct(ReportRepositoryInterface $report)
    {
        $this -> report = $report;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Invoices Reports', ['only' => ['invoicesReports', 'numberSearch', 'dateSearch']]);
            $this->middleware('permission:Customer Reports', ['only' => ['customersReports', 'customersSearch']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:تقارير الفواتير', ['only' => ['invoicesReports', 'numberSearch', 'dateSearch']]);
            $this->middleware('permission:تقارير العملاء', ['only' => ['customersReports', 'customersSearch']]);
        }
    }

    public function invoicesReports()
    {
        return $this -> report -> invoicesReports();
    }

    public function numberSearch(InvoiceNumberReportsRequest $request)
    {
        return $this -> report -> numberSearch($request);
    }

    public function dateSearch(InvoiceDateReportsRequest $request)
    {
        return $this -> report -> dateSearch($request);
    }

    public function customersReports()
    {
        return $this -> report -> customersReports();
    }

    public function customersSearch(CustomersReportsRequest $request)
    {
        return $this -> report -> customersSearch($request);
    }
}
