<?php

namespace App\Interfaces\Reports;

interface ReportRepositoryInterface
{
    public function invoicesReports();

    public function numberSearch($request);

    public function dateSearch($request);

    public function customersReports();

    public function customersSearch($request);
}
