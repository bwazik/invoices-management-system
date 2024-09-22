<?php

namespace App\Interfaces\Invoices;

interface InvoiceDetailsRepositoryInterface
{
    public function getInvoiceDetails($id);

    public function show($number, $file);

    public function download($number, $file);

    public function delete($id, $number, $file);

    public function addAttachment($request, $invoice_id);

    public function deleteAllAttachments($request, $invoice_id);
}
