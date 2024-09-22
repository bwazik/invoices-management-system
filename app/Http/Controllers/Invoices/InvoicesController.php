<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\AttachmentsRequest;
use App\Http\Requests\Invoices\ChangePaymentStatusRequest;
use App\Http\Requests\Invoices\InvoicesRequest;
use Illuminate\Http\Request;
use App\Interfaces\Invoices\InvoiceRepositoryInterface;

class InvoicesController extends Controller
{
    protected $invoice;

    public function __construct(InvoiceRepositoryInterface $invoice)
    {
        $this -> invoice = $invoice;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Invoices List', ['only' => ['index']]);
            $this->middleware('permission:Paid Invoices', ['only' => ['paidInvoices']]);
            $this->middleware('permission:Unpaid Invoices', ['only' => ['unpaidInvoices']]);
            $this->middleware('permission:Partial Paid Invoices', ['only' => ['partialPaidInvoices']]);
            $this->middleware('permission:Add Invoice', ['only' => ['add', 'getProducts']]);
            $this->middleware('permission:Edit Invoice', ['only' => ['edit']]);
            $this->middleware('permission:Delete Invoice', ['only' => ['delete']]);
            $this->middleware('permission:Delete Selected Invoices', ['only' => ['deleteSelected']]);
            $this->middleware('permission:Change Payment Status', ['only' => ['changePaymentStatus']]);
            $this->middleware('permission:Archive Invoice', ['only' => ['archiveInvoice']]);
            $this->middleware('permission:Archive Selected Invoices', ['only' => ['archiveSelected']]);
            $this->middleware('permission:Print Invoice', ['only' => ['printInvoice']]);
            $this->middleware('permission:Excel Export', ['only' => ['exportInvoices', 'exportPaidInvoices', 'exportUnpaidInvoices', 'exportPartialPaidInvoices']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
            $this->middleware('permission:الفواتير المدفوعة', ['only' => ['paidInvoices']]);
            $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['unpaidInvoices']]);
            $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['partialPaidInvoices']]);
            $this->middleware('permission:إضافة فاتورة', ['only' => ['add', 'getProducts']]);
            $this->middleware('permission:تعديل فاتورة', ['only' => ['edit']]);
            $this->middleware('permission:حذف فاتورة', ['only' => ['delete']]);
            $this->middleware('permission:حذف الفواتير المختارة', ['only' => ['deleteSelected']]);
            $this->middleware('permission:تعديل حالة الدفع', ['only' => ['changePaymentStatus']]);
            $this->middleware('permission:أرشفة فاتورة', ['only' => ['archiveInvoice']]);
            $this->middleware('permission:أرشفة الفواتير المختارة', ['only' => ['archiveSelected']]);
            $this->middleware('permission:طباعة فاتورة', ['only' => ['printInvoice']]);
            $this->middleware('permission:تصدير اكسيل', ['only' => ['exportInvoices', 'exportPaidInvoices', 'exportUnpaidInvoices', 'exportPartialPaidInvoices']]);
        }
    }

    public function index(Request $request)
    {
        return $this -> invoice -> getAllInvoices($request);
    }

    public function paidInvoices(Request $request)
    {
        return $this -> invoice -> paidInvoices($request);
    }

    public function unpaidInvoices(Request $request)
    {
        return $this -> invoice -> unpaidInvoices($request);
    }

    public function partialPaidInvoices(Request $request)
    {
        return $this -> invoice -> partialPaidInvoices($request);
    }

    public function getProducts($id)
    {
        return $this -> invoice -> getProducts($id);
    }

    public function add(InvoicesRequest $request)
    {
        return $this -> invoice -> addInvoice($request);
    }

    public function edit(InvoicesRequest $request)
    {
        return $this -> invoice -> editInvoice($request);
    }

    public function deleteInvoice(Request $request)
    {
        return $this -> invoice -> deleteInvoice($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> invoice -> deleteSelectedInvoices($request);
    }

    public function changePaymentStatus(ChangePaymentStatusRequest $request)
    {
        return $this -> invoice -> changePaymentStatus($request);
    }

    public function archiveInvoice(Request $request)
    {
        return $this -> invoice -> archiveInvoice($request);
    }

    public function archiveSelected(Request $request)
    {
        return $this -> invoice -> archiveSelectedInvoices($request);
    }

    public function printInvoice($id)
    {
        return $this -> invoice -> printInvoice($id);
    }

    public function exportInvoices()
    {
        return $this -> invoice -> exportInvoices();
    }

    public function exportPaidInvoices()
    {
        return $this -> invoice -> exportPaidInvoices();
    }

    public function exportUnpaidInvoices()
    {
        return $this -> invoice -> exportUnpaidInvoices();
    }

    public function exportPartialPaidInvoices()
    {
        return $this -> invoice -> exportPartialPaidInvoices();
    }
}
