<?php

namespace App\Interfaces\Invoices;

interface InvoicesArchiveRepositoryInterface
{
    public function getAllArchivedInvoices($request);

    public function unarchiveInvoice($request);

    public function unarchiveSelectedInvoices($request);
    
    public function deleteInvoice($request);

}
