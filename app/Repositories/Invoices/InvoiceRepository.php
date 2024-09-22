<?php

namespace App\Repositories\Invoices;

use App\Interfaces\Invoices\InvoiceRepositoryInterface;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoiceAttachment;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use App\Notifications\AddInvoice;
use App\Exports\InvoicesExport;
use App\Exports\PaidInvoicesExport;
use App\Exports\UnpaidInvoicesExport;
use App\Exports\PartialPaidInvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAllInvoices($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::select('id', 'number', 'date', 'due_date', 'collection_amount', 'commission_amount', 'discount', 'vat', 'vat_value', 'total', 'status', 'note', 'section_id', 'product_id')->get();
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

                    $detailsBtn = '';
                    $editBtn = '';
                    $deleteBtn = '';
                    $archiveBtn = '';
                    $paymentBtn = '';
                    $printBtn = '';

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="dropdown-item" href="'. route('getInvoiceDetails' , $row -> id) .'"><i class="text-primary fas fa-receipt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.info").'</a>';
                    }
                    if (Auth::user()->can('تعديل فاتورة') or Auth::user()->can('Edit Invoice')){
                        $editBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="editBtn" data-target="#editModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'"
                            ><i class="text-warning far fa-edit"></i>&nbsp;&nbsp;'.trans("invoices/invoices.edit").'</a>
                            ';
                    }
                    if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice')){
                        $deleteBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-danger far fa-trash-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.delete").'</a>
                            ';
                    }
                    if (Auth::user()->can('أرشفة فاتورة') or Auth::user()->can('Archive Invoice')){
                        $archiveBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="archiveBtn" data-target="#archiveModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-success fas fa-exchange-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.archive").'</a>
                            ';
                    }
                    if (Auth::user()->can('تعديل حالة الدفع') or Auth::user()->can('Change Payment Status')){
                        $paymentBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="paymentBtn" data-target="#paymentModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'" data-status="'.$row -> status.'"
                            ><i class="text-info fas fa-dollar-sign"></i>&nbsp;&nbsp;'.trans("invoices/invoices.payment").'</a>
                            ';
                    }
                    if (Auth::user()->can('طباعة فاتورة') or Auth::user()->can('Print Invoice')){
                        $printBtn = '<a class="dropdown-item" href="'. route('printInvoice' , $row -> id) .'"><i class="text-secondary fas fa-print"></i>&nbsp;&nbsp;'.trans("invoices/invoices.print").'</a>
                            ';
                    }

                    return '<div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    '.trans("invoices/invoices.processes").'
                                </button>
                                <div class="dropdown-menu">
                                    '.$detailsBtn.'

                                    '.$editBtn.'

                                    '.$deleteBtn.'

                                    '.$archiveBtn.'

                                    '.$paymentBtn.'

                                    '.$printBtn.'
                                </div>
                            </div>';
                })
                ->rawColumns(['selectbox', 'total', 'status', 'user', 'section', 'product', 'details'])
                ->make(true);
        }

        $sections = Section::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();

        return view('invoices.index', compact('sections', 'products'));
    }

    public function paidInvoices($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::select('id', 'number', 'date', 'due_date', 'collection_amount', 'commission_amount', 'discount', 'vat', 'vat_value', 'total', 'status', 'note', 'section_id', 'product_id')->where('status', 1)->get();
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

                    $detailsBtn = '';
                    $editBtn = '';
                    $deleteBtn = '';
                    $archiveBtn = '';
                    $paymentBtn = '';
                    $printBtn = '';

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="dropdown-item" href="'. route('getInvoiceDetails' , $row -> id) .'"><i class="text-primary fas fa-receipt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.info").'</a>';
                    }
                    if (Auth::user()->can('تعديل فاتورة') or Auth::user()->can('Edit Invoice')){
                        $editBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="editBtn" data-target="#editModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'"
                            ><i class="text-warning far fa-edit"></i>&nbsp;&nbsp;'.trans("invoices/invoices.edit").'</a>
                            ';
                    }
                    if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice')){
                        $deleteBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-danger far fa-trash-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.delete").'</a>
                            ';
                    }
                    if (Auth::user()->can('أرشفة فاتورة') or Auth::user()->can('Archive Invoice')){
                        $archiveBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="archiveBtn" data-target="#archiveModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-success fas fa-exchange-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.archive").'</a>
                            ';
                    }
                    if (Auth::user()->can('تعديل حالة الدفع') or Auth::user()->can('Change Payment Status')){
                        $paymentBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="paymentBtn" data-target="#paymentModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'" data-status="'.$row -> status.'"
                            ><i class="text-info fas fa-dollar-sign"></i>&nbsp;&nbsp;'.trans("invoices/invoices.payment").'</a>
                            ';
                    }
                    if (Auth::user()->can('طباعة فاتورة') or Auth::user()->can('Print Invoice')){
                        $printBtn = '<a class="dropdown-item" href="'. route('printInvoice' , $row -> id) .'"><i class="text-secondary fas fa-print"></i>&nbsp;&nbsp;'.trans("invoices/invoices.print").'</a>
                            ';
                    }

                    return '<div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    '.trans("invoices/invoices.processes").'
                                </button>
                                <div class="dropdown-menu">
                                    '.$detailsBtn.'

                                    '.$editBtn.'

                                    '.$deleteBtn.'

                                    '.$archiveBtn.'

                                    '.$paymentBtn.'

                                    '.$printBtn.'
                                </div>
                            </div>';
                })
                ->rawColumns(['selectbox', 'total', 'status', 'user', 'section', 'product', 'details'])
                ->make(true);
        }

        $sections = Section::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();

        return view('invoices.paid.index', compact('sections', 'products'));

    }

    public function unpaidInvoices($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::select('id', 'number', 'date', 'due_date', 'collection_amount', 'commission_amount', 'discount', 'vat', 'vat_value', 'total', 'status', 'note', 'section_id', 'product_id')->where('status', 2)->get();
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

                    $detailsBtn = '';
                    $editBtn = '';
                    $deleteBtn = '';
                    $archiveBtn = '';
                    $paymentBtn = '';
                    $printBtn = '';

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="dropdown-item" href="'. route('getInvoiceDetails' , $row -> id) .'"><i class="text-primary fas fa-receipt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.info").'</a>';
                    }
                    if (Auth::user()->can('تعديل فاتورة') or Auth::user()->can('Edit Invoice')){
                        $editBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="editBtn" data-target="#editModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'"
                            ><i class="text-warning far fa-edit"></i>&nbsp;&nbsp;'.trans("invoices/invoices.edit").'</a>
                            ';
                    }
                    if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice')){
                        $deleteBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-danger far fa-trash-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.delete").'</a>
                            ';
                    }
                    if (Auth::user()->can('أرشفة فاتورة') or Auth::user()->can('Archive Invoice')){
                        $archiveBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="archiveBtn" data-target="#archiveModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-success fas fa-exchange-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.archive").'</a>
                            ';
                    }
                    if (Auth::user()->can('تعديل حالة الدفع') or Auth::user()->can('Change Payment Status')){
                        $paymentBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="paymentBtn" data-target="#paymentModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'" data-status="'.$row -> status.'"
                            ><i class="text-info fas fa-dollar-sign"></i>&nbsp;&nbsp;'.trans("invoices/invoices.payment").'</a>
                            ';
                    }
                    if (Auth::user()->can('طباعة فاتورة') or Auth::user()->can('Print Invoice')){
                        $printBtn = '<a class="dropdown-item" href="'. route('printInvoice' , $row -> id) .'"><i class="text-secondary fas fa-print"></i>&nbsp;&nbsp;'.trans("invoices/invoices.print").'</a>
                            ';
                    }

                    return '<div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    '.trans("invoices/invoices.processes").'
                                </button>
                                <div class="dropdown-menu">
                                    '.$detailsBtn.'

                                    '.$editBtn.'

                                    '.$deleteBtn.'

                                    '.$archiveBtn.'

                                    '.$paymentBtn.'

                                    '.$printBtn.'
                                </div>
                            </div>';
                })
                ->rawColumns(['selectbox', 'total', 'status', 'user', 'section', 'product', 'details'])
                ->make(true);
        }

        $sections = Section::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();

        return view('invoices.unpaid.index', compact('sections', 'products'));

    }

    public function partialPaidInvoices($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::select('id', 'number', 'date', 'due_date', 'collection_amount', 'commission_amount', 'discount', 'vat', 'vat_value', 'total', 'status', 'note', 'section_id', 'product_id')->where('status', 3)->get();
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

                    $detailsBtn = '';
                    $editBtn = '';
                    $deleteBtn = '';
                    $archiveBtn = '';
                    $paymentBtn = '';
                    $printBtn = '';

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="dropdown-item" href="'. route('getInvoiceDetails' , $row -> id) .'"><i class="text-primary fas fa-receipt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.info").'</a>';
                    }
                    if (Auth::user()->can('تعديل فاتورة') or Auth::user()->can('Edit Invoice')){
                        $editBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="editBtn" data-target="#editModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'"
                            ><i class="text-warning far fa-edit"></i>&nbsp;&nbsp;'.trans("invoices/invoices.edit").'</a>
                            ';
                    }
                    if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice')){
                        $deleteBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-danger far fa-trash-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.delete").'</a>
                            ';
                    }
                    if (Auth::user()->can('أرشفة فاتورة') or Auth::user()->can('Archive Invoice')){
                        $archiveBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="archiveBtn" data-target="#archiveModal"
                            data-id="'.$row -> id.'" data-number="'.$row -> number.'"
                            ><i class="text-success fas fa-exchange-alt"></i>&nbsp;&nbsp;'.trans("invoices/invoices.archive").'</a>
                            ';
                    }
                    if (Auth::user()->can('تعديل حالة الدفع') or Auth::user()->can('Change Payment Status')){
                        $paymentBtn = '<a class="dropdown-item" href="#"
                            data-toggle="modal" id="paymentBtn" data-target="#paymentModal"
                            data-id="'.$row -> id.'"
                            data-number="'.$row -> number.'" data-date="'.$row -> date.'" data-due_date="'.$row -> due_date.'"
                            data-section="'.$row -> section_id.'" data-product="'.$row -> product_id.'"
                            data-collection_amount="'.$row -> collection_amount.'" data-commission_amount="'.$row -> commission_amount.'"
                            data-discount="'.$row -> discount.'" data-vat="'.$row -> vat.'" data-vat_value="'.$row -> vat_value.'"
                            data-total="'.$row -> total.'" data-note="'.$row -> note.'" data-status="'.$row -> status.'"
                            ><i class="text-info fas fa-dollar-sign"></i>&nbsp;&nbsp;'.trans("invoices/invoices.payment").'</a>
                            ';
                    }
                    if (Auth::user()->can('طباعة فاتورة') or Auth::user()->can('Print Invoice')){
                        $printBtn = '<a class="dropdown-item" href="'. route('printInvoice' , $row -> id) .'"><i class="text-secondary fas fa-print"></i>&nbsp;&nbsp;'.trans("invoices/invoices.print").'</a>
                            ';
                    }

                    return '<div class="btn-group">
                                <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    '.trans("invoices/invoices.processes").'
                                </button>
                                <div class="dropdown-menu">
                                    '.$detailsBtn.'

                                    '.$editBtn.'

                                    '.$deleteBtn.'

                                    '.$archiveBtn.'

                                    '.$paymentBtn.'

                                    '.$printBtn.'
                                </div>
                            </div>';
                })
                ->rawColumns(['selectbox', 'total', 'status', 'user', 'section', 'product', 'details'])
                ->make(true);
        }

        $sections = Section::select('id', 'name')->get();
        $products = Product::select('id', 'name')->get();

        return view('invoices.partialpaid.index', compact('sections', 'products'));

    }

    public function getProducts($id)
    {
        $products = Product::where('section_id', $id)->pluck('name', 'id');

        return $products;
    }

    public function addInvoice($request)
    {
        DB::beginTransaction();

        Invoice::create([
            'number' => $request -> number,
            'date' => $request -> date,
            'due_date' => $request -> due_date,
            'section_id' => $request -> section,
            'product_id' => $request -> product,
            'collection_amount' => $request -> collection_amount,
            'commission_amount' => $request -> commission_amount,
            'discount' => $request -> discount,
            'vat' => $request -> vat,
            'vat_value' => $request -> vat_value,
            'total' => $request -> total,
            'status' => 2,
            'note' => $request -> note,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        InvoiceDetail::create([
            'number' => $request -> number,
            'status' => 2,
            'invoice_id' => $invoice_id,
            'section_id' => $request -> section,
            'product_id' => $request -> product,
            'user_id' => (Auth::user() -> id),
            'note' => $request -> note,
        ]);

        if ($request -> hasFile('attachments')) {

            $invoice_id = Invoice::latest() -> first() -> id;

            $name = $request -> attachments -> getClientOriginalName();
            $request -> attachments -> storeAs('attachments/invoices/'.$request -> number, $name, 'attachments');

            InvoiceAttachment::create([
                'number' => $request -> number,
                'file' => $name,
                'invoice_id' => $invoice_id,
                'user_id' => (Auth::user() -> id),
            ]);
        }

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('invoices/invoices.added')]);
    }

    public function editInvoice($request)
    {
        DB::beginTransaction();

        $invoice = Invoice::findOrFail($request -> id);

        $invoice -> update([
            $invoice -> number = $request -> number,
            $invoice -> date = $request -> date,
            $invoice -> due_date = $request -> due_date,
            $invoice -> section_id = $request -> section,
            $invoice -> product_id = $request -> product,
            $invoice -> collection_amount = $request -> collection_amount,
            $invoice -> commission_amount = $request -> commission_amount,
            $invoice -> discount = $request -> discount,
            $invoice -> vat = $request -> vat,
            $invoice -> vat_value = $request -> vat_value,
            $invoice -> total = $request -> total,
            $invoice -> note = $request -> note,
        ]);

        InvoiceDetail::create([
            'number' => $request -> number,
            'status' => 3,
            'invoice_id' => $request -> id,
            'section_id' => $request -> section,
            'product_id' => $request -> product,
            'user_id' => (Auth::user() -> id),
            'note' => $request -> note,
        ]);

        DB::commit();
        DB::rollback();

        return response()->json(['success' => trans('invoices/invoices.edited')]);
    }

    public function deleteInvoice($request)
    {
        $invoice = Invoice::findOrFail($request -> id);

        $attachments = InvoiceAttachment::where('invoice_id', $request -> id)->first();

        if(!empty($attachments -> number))
        {
            $file = new Filesystem;
            $file->deleteDirectory(Storage::disk('attachments')->path('attachments/invoices/'.$attachments -> number));
        }

        $invoice->forceDelete();

        return response()->json(['success' => trans('invoices/invoices.deleted')]);
    }

    public function deleteSelectedInvoices($request)
    {
        $delete_selected_id = explode("," , $request -> delete_selected_id);

        $attachments = InvoiceAttachment::whereIn('invoice_id', $delete_selected_id)->get();

        if(!$attachments->isEmpty())
        {
            $file = new Filesystem;

            foreach ($attachments as $attachment)
            {
                $file->deleteDirectory(Storage::disk('attachments')->path('attachments/invoices/'.$attachment -> number));
            }
        }

        Invoice::whereIn('id', $delete_selected_id)->forceDelete();

        return response()->json(['success' => trans('invoices/invoices.deleted_selected')]);
    }

    public function changePaymentStatus($request)
    {
        DB::beginTransaction();

        $invoice = Invoice::findOrFail($request -> id);

        $invoice -> update([
            'status' => $request -> payment_status,
            'payment_date' => $request -> payment_date,
        ]);

        InvoiceDetail::create([
            'number' => $request -> number,
            'payment_date' => $request -> payment_date,
            'status' => $request -> payment_status,
            'invoice_id' => $request -> id,
            'section_id' => $request -> section,
            'product_id' => $request -> product,
            'user_id' => (Auth::user() -> id),
            'note' => $request -> note,
        ]);

        DB::commit();
        DB::rollback();

        if($request -> payment_status == 1)
        {
            $invoice_id = $request -> id;
            $number = $request -> number;
            $user = User::first();
            $user->notify(new AddInvoice($invoice_id, $number));
        }

        return response()->json(['success' => trans('invoices/invoices.payment_changed')]);
    }

    public function archiveInvoice($request)
    {
        Invoice::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('invoices/invoices.archived')]);
    }

    public function archiveSelectedInvoices($request)
    {
        $archive_selected_id = explode("," , $request -> archive_selected_id);

        Invoice::whereIn('id', $archive_selected_id)->delete();

        return response()->json(['success' => trans('invoices/invoices.archived_selected')]);
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('invoices.print', compact('invoice'));
    }

    public function exportInvoices()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    public function exportPaidInvoices()
    {
        return Excel::download(new PaidInvoicesExport, 'paid-invoices.xlsx');
    }

    public function exportUnpaidInvoices()
    {
        return Excel::download(new UnpaidInvoicesExport, 'unpaid-invoices.xlsx');
    }

    public function exportPartialPaidInvoices()
    {
        return Excel::download(new PartialPaidInvoicesExport, 'partial-paid-invoices.xlsx');
    }
}
