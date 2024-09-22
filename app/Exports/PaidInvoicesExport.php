<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaidInvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::select('id', 'due_date', 'number', 'collection_amount', 'commission_amount', 'total', 'status')->where('status', 1)->get();
    }
}
