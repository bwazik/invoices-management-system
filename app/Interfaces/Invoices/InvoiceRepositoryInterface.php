<?php

namespace App\Interfaces\Invoices;

interface InvoiceRepositoryInterface
{
    public function getAllInvoices($request);

    public function paidInvoices($request);

    public function unpaidInvoices($request);

    public function partialPaidInvoices($request);

    public function getProducts($id);

    public function addInvoice($request);

    public function editInvoice($request);

    public function deleteInvoice($request);

    public function deleteSelectedInvoices($request);

    public function changePaymentStatus($request);

    public function archiveInvoice($request);

    public function archiveSelectedInvoices($request);

    public function printInvoice($id);

    public function exportInvoices();

    public function exportPaidInvoices();

    public function exportUnpaidInvoices();

    public function exportPartialPaidInvoices();
}
