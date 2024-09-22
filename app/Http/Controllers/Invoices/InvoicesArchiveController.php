<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Interfaces\Invoices\InvoicesArchiveRepositoryInterface;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{
    protected $invoice;

    public function __construct(InvoicesArchiveRepositoryInterface $invoice)
    {
        $this -> invoice = $invoice;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Invoices Archive', ['only' => ['index']]);
            $this->middleware('permission:Unarchive Invoice', ['only' => ['unarchiveInvoice']]);
            $this->middleware('permission:Unarchive Selected Invoices', ['only' => ['unarchiveSelected']]);
            $this->middleware('permission:Delete Invoice', ['only' => ['deleteInvoice']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:أرشيف الفواتير', ['only' => ['index']]);
            $this->middleware('permission:إلغاء أرشفة فاتورة', ['only' => ['unarchiveInvoice']]);
            $this->middleware('permission:إالغاء أرشفة الفواتير المختارة', ['only' => ['unarchiveSelected']]);
            $this->middleware('permission:حذف فاتورة', ['only' => ['deleteInvoice']]);
        }
    }

    public function index(Request $request)
    {
        return $this -> invoice -> getAllArchivedInvoices($request);
    }

    public function unarchiveInvoice(Request $request)
    {
        return $this -> invoice -> unarchiveInvoice($request);
    }

    public function unarchiveSelected(Request $request)
    {
        return $this -> invoice -> unarchiveSelectedInvoices($request);
    }

    public function deleteInvoice(Request $request)
    {
        return $this -> invoice -> deleteInvoice($request);
    }
}
