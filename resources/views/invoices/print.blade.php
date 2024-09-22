@extends('layouts.master')

@section('css')

@endsection

@section('mainTitle')
    {{ trans('invoices/print.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('printInvoice', $invoice -> id) }}">{{ trans('invoices/print.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('printInvoice', $invoice -> id) }}">{{ trans('invoices/print.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('invoices/print.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="mb-20"><img class="logo-small mt-0" src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="logo"></div>
                        <ul class="addresss-info invoice-addresss list-unstyled">
                            <li>Cairo Ali Basha St.150,<br>
                            45 Apartment - Nasr City</li>
                            <li><strong>{{ trans('invoices/print.email') }}: </strong> {{ Auth::user()->email }}</li>
                            <li><strong>{{ trans('invoices/print.phone') }}: </strong> <a href="tel:201098617164"> +201098617164 </a></li>
                        </ul>
                        </div>
                        <div class="col-sm-6 text-start text-sm-end mb-5">
                        <h4>{{ trans('invoices/print.information') }}</h4>
                        <div>
                            <p> {{ trans('invoices/invoices.number') }}: <a href="{{ route('getInvoiceDetails', $invoice -> id) }}">#{{ $invoice -> number }}</a> </p> <br>
                            <h4><small>{{ trans('invoices/print.to') }}:</small> {{ Auth::user()->name }}</h4>
                        </div>
                        <ul class="addresss-info invoice-addresss list-unstyled">
                            <li> Cairo Ali Basha St.150,<br>
                            45 Apartment - Nasr City</li>
                            <li><strong>{{ trans('invoices/print.email') }}: </strong> {{ Auth::user()->email }}</li>
                            <li><strong>{{ trans('invoices/print.phone') }}: </strong> <a href="tel:201098617164"> +201098617164 </a></li>
                        </ul>
                        <span>{{ trans('invoices/invoices.date') }}: {{ $invoice -> date }}</span>
                        <br>
                        <span>{{ trans('invoices/invoices.due_date') }}: {{ $invoice -> due_date }}</span>
                        <br>
                        <span>{{ trans('invoices/invoices.section') }}: {{ $invoice -> section -> name }}</span>
                        </div>
                    </div>
                    <div class="page-invoice-table table-responsive">
                        <table class="table table-hover text-end">
                        <thead>
                            <tr>
                            <th class="text-center">#</th>
                            <th class="text-start">{{ trans('invoices/invoices.product') }}</th>
                            <th class="text-end">{{ trans('invoices/invoices.collection_amount') }}</th>
                            <th class="text-end">{{ trans('invoices/invoices.commission_amount') }}</th>
                            <th class="text-end">{{ trans('invoices/invoices.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td class="text-center">01</td>
                            <td class="text-start">{{ $invoice -> product -> name }}</td>
                            <td>{{ number_format($invoice -> collection_amount, 2) }}</td>
                            <td>{{ number_format($invoice -> commission_amount, 2) }}</td>
                            @php $total = $invoice -> collection_amount + $invoice -> commission_amount @endphp
                            <td>{{ number_format($total, 2)  }}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <div class="text-end clearfix mb-3 mt-2">
                        <div class="float-end mt-30">
                        <h6>{{ trans('invoices/invoices.total') }}: <strong>{{ number_format($total, 2)  }}</strong></h6>
                        <h6>{{ trans('invoices/invoices.vat') }} ({{ $invoice -> vat }}): <strong>{{ $invoice -> vat_value }}</strong></h6>
                        <h6>{{ trans('invoices/invoices.discount') }}: <strong>{{ number_format($invoice -> discount, 2)  }}</strong></h6>
                        <h6 class="grand-invoice-amount">{{ trans('invoices/print.total') }}: <strong>{{ number_format($invoice -> total, 2)  }}</strong></h6>
                        </div>
                    </div>
                    <div class="text-end">
                        <button id="print_btn" type="button" class="btn btn-dark" onclick="javascript:window.print();">
                        <span><i class="fa fa-print"></i> {{ trans('invoices/print.print') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

