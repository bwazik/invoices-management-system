<?php

namespace App\Repositories\Reports;

use App\Interfaces\Reports\ReportRepositoryInterface;
use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class ReportRepository implements ReportRepositoryInterface
{
    public function invoicesReports()
    {
        return view('reports.invoices');
    }

    public function numberSearch($request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::select('id', 'number', 'total', 'status', 'section_id', 'product_id')->where('number', $request -> number)->get();

            return datatables()->of($invoices)
                ->addIndexColumn()
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

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="btn btn-outline-info btn-md" href="'. route('getInvoiceDetails' , $row -> id) .'">'.trans("invoices/invoices.info").'</a>';
                    }

                    return $detailsBtn;
                })
                ->rawColumns(['total', 'status', 'section', 'product', 'details'])
                ->make(true);
        }
    }

    public function dateSearch($request)
    {
        if ($request->ajax()) {

            $invoices = "";

            if($request -> status == 4)
            {
                $invoices = Invoice::whereBetween('date' , [$request -> start_date , $request -> end_date])->get();
            }
            else
            {
                $invoices = Invoice::whereBetween('date' , [$request -> start_date , $request -> end_date])->where('status' , $request -> status)->get();
            }

            return datatables()->of($invoices)
                ->addIndexColumn()
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

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="btn btn-outline-info btn-md" href="'. route('getInvoiceDetails' , $row -> id) .'">'.trans("invoices/invoices.info").'</a>';
                    }

                    return $detailsBtn;
                })

                ->rawColumns(['total', 'status', 'section', 'product', 'details'])
                ->make(true);
        }
    }

    public function customersReports()
    {
        $sections = Section::select('id', 'name')->get();

        return view('reports.customers', compact('sections'));
    }

    public function customersSearch($request)
    {
        if ($request->ajax()) {

            $invoices = "";

            if ($request -> section && $request -> product && $request -> start_date == '' && $request -> end_date=='')
            {
                $invoices = Invoice::select('id', 'number', 'total', 'status', 'section_id', 'product_id')->where('section_id' , $request -> section)->where('product_id' , $request -> product)->get();
            }
            else
            {
                $invoices = Invoice::whereBetween('date' , [$request -> start_date , $request -> end_date])->where('section_id' , $request -> section)->where('product_id' , $request -> product)->get();
            }

            return datatables()->of($invoices)
                ->addIndexColumn()
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

                    if(Auth::user()->can('معلومات الفاتورة') or Auth::user()->can('Invoice Info')){
                        $detailsBtn = '<a class="btn btn-outline-info btn-md" href="'. route('getInvoiceDetails' , $row -> id) .'">'.trans("invoices/invoices.info").'</a>';
                    }

                    return $detailsBtn;
                })

                ->rawColumns(['total', 'status', 'section', 'product', 'details'])
                ->make(true);
        }
    }
}
