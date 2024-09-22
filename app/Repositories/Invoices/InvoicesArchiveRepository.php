<?php

namespace App\Repositories\Invoices;

use App\Interfaces\Invoices\InvoicesArchiveRepositoryInterface;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InvoicesArchiveRepository implements InvoicesArchiveRepositoryInterface
{
    public function getAllArchivedInvoices($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::onlyTrashed()->select('id', 'number', 'date', 'due_date', 'collection_amount', 'commission_amount', 'discount', 'vat', 'vat_value', 'total', 'status', 'note', 'section_id', 'product_id')->get();
            return datatables()->of($invoices)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="box1">';
                    return $btn;
                })
                ->editColumn('total', function ($row) {
                    return number_format($row -> total, 2);
                })
                ->editColumn('status', function ($row) {
                    if ($row -> status == 1){
                        return '<span class="badge badge-success">'.trans("invoices/invoices.paid").'</span>';
                    }
                    elseif($row -> status == 2){
                        return '<span class="badge badge-danger">'.trans("invoices/invoices.unpaid").'</span>';
                    }
                    elseif($row -> status == 3){
                        return '<span class="badge badge-warning">'.trans("invoices/invoices.partial").'</span>';
                    }
                })
                ->addColumn('section', function ($row) {
                    return $row -> section -> name;
                })
                ->addColumn('product', function ($row) {
                    return $row -> product -> name;
                })
                ->addColumn('details', function ($row) {

                    $unarchiveBtn = '';
                    $deleteBtn = '';

                    if (Auth::user()->can('إلغاء أرشفة فاتورة') or Auth::user()->can('Unarchive Invoice')){
                        $unarchiveBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="unarchiveBtn" data-target="#unarchiveModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-success fas fa-exchange-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.unrchive").'</a>
                            ';
                    }
                    
                    if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice')){
                        $deleteBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-danger far fa-trash-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.delete").'</a>
                            ';
                    }

                    return '<div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    '.trans("invoices/invoices.processes").'
                                </button>
                                <div class="dropdown-menu">
                                    '.$unarchiveBtn.'

                                    '.$deleteBtn.'
                                </div>
                            </div>';
                })
                ->rawColumns(['selectbox', 'total', 'status', 'section', 'product', 'details'])
                ->make(true);
        }

        return view('invoices.archive.index');
    }

    public function unarchiveInvoice($request)
    {
        Invoice::withTrashed()->findOrFail($request -> id)->restore();

        return response()->json(['success' => trans('invoices/invoices.unarchived')]);
    }

    public function unarchiveSelectedInvoices($request)
    {
        $unarchive_selected_id = explode("," , $request -> unarchive_selected_id);

        Invoice::whereIn('id', $unarchive_selected_id)->restore();

        return response()->json(['success' => trans('invoices/invoices.unarchived_selected')]);
    }

    public function deleteInvoice($request)
    {
        $invoice = Invoice::withTrashed()->findOrFail($request -> id);

        $attachments = InvoiceAttachment::where('invoice_id', $request -> id)->first();

        if(!empty($attachments -> number))
        {
            $file = new Filesystem;
            $file->deleteDirectory(Storage::disk('attachments')->path('attachments/invoices/'.$attachments -> number));
        }

        $invoice->forceDelete();

        return response()->json(['success' => trans('invoices/invoices.deleted')]);
    }
}
