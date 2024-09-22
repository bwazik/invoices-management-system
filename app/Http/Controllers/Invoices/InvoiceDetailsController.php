<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\AttachmentsRequest;
use Illuminate\Http\Request;
use App\Interfaces\Invoices\InvoiceDetailsRepositoryInterface;

class InvoiceDetailsController extends Controller
{
    protected $invoice;

    public function __construct(InvoiceDetailsRepositoryInterface $invoice)
    {
        $this -> invoice = $invoice;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Invoice Info', ['only' => ['getInvoiceDetails']]);
            $this->middleware('permission:Show Attachment', ['only' => ['show']]);
            $this->middleware('permission:Download Attachment', ['only' => ['download']]);
            $this->middleware('permission:Delete Attachment', ['only' => ['delete']]);
            $this->middleware('permission:Add Attachment', ['only' => ['addAttachment']]);
            $this->middleware('permission:Delete All Attachments', ['only' => ['deleteAllAttachments']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:معلومات الفاتورة', ['only' => ['getInvoiceDetails']]);
            $this->middleware('permission:عرض مرفق', ['only' => ['show']]);
            $this->middleware('permission:تحميل مرفق', ['only' => ['download']]);
            $this->middleware('permission:حذف مرفق', ['only' => ['delete']]);
            $this->middleware('permission:إضافة مرفق', ['only' => ['addAttachment']]);
            $this->middleware('permission:حذف جميع المرفقات', ['only' => ['deleteAllAttachments']]);
        }
    }

    public function getInvoiceDetails($id)
    {
        return $this -> invoice -> getInvoiceDetails($id);
    }

    public function show($number, $file)
    {
        return $this -> invoice -> show($number, $file);
    }

    public function download($number, $file)
    {
        return $this -> invoice -> download($number, $file);
    }

    public function delete($id, $number, $file)
    {
        return $this -> invoice -> delete($id, $number, $file);
    }

    public function addAttachment(AttachmentsRequest $request, $invoice_id)
    {
        return $this -> invoice -> addAttachment($request, $invoice_id);
    }

    public function deleteAllAttachments(Request $request, $invoice_id)
    {
        return $this -> invoice -> deleteAllAttachments($request, $invoice_id);
    }
}
