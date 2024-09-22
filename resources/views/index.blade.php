@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('layouts/sidebar.dashboard') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('pageTitle1')
    {{ trans('layouts/sidebar.dashboard') }}
@endsection

@section('pageTitle2')
    {{ trans('layouts/sidebar.dashboard') }}
@endsection

@section('subTitle')
    {{ trans('layouts/sidebar.dashboard') }}
@endsection

@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-100 bg-info">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-start">
                <span class="text-white">
                <i class="fa fa-receipt highlight-icon" aria-hidden="true"></i>
                </span>
            </div>
            <div class="float-end text-end">
                <p class="card-text text-white">{{ trans('layouts/sidebar.invoices') }}</p>
                <h4 class="text-white">${{ $all_sum }}</h4>
            </div>
            </div>
            <p class="mt-3 text-white pt-3 border-top border-white">
            <i class="fa fa-magnifying-glass me-1" aria-hidden="true"></i> <a href="{{ route('invoices') }}">{{ trans('layouts/sidebar.report.invoices') }} ({{ $all_count }})</a>
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-100 bg-success">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-start">
                <span class="text-white">
                <i class="fa fa-circle-check highlight-icon" aria-hidden="true"></i>
                </span>
            </div>
            <div class="float-end text-end">
                <p class="card-text text-white">{{ trans('layouts/sidebar.invoice.paid') }}</p>
                <h4 class="text-white">${{ $paid_sum }}</h4>
            </div>
            </div>
            <p class="text-white mt-3 pt-3 border-top border-white">
            <i class="fa fa-magnifying-glass me-1" aria-hidden="true"></i> <a href="{{ route('paidInvoices') }}">{{ trans('layouts/sidebar.report.invoices') }} ({{ $paid_count }})</a>
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-100 bg-warning">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-start">
                <span class="text-white">
                <i class="fa fa-hourglass-half highlight-icon" aria-hidden="true"></i>
                </span>
            </div>
            <div class="float-end text-end">
                <p class="card-text text-white">{{ trans('layouts/sidebar.invoice.partial') }}</p>
                <h4 class="text-white">${{ $partial_paid_sum }}</h4>
            </div>
            </div>
            <p class="text-white mt-3 pt-3 border-top border-white">
            <i class="fa fa-magnifying-glass me-1" aria-hidden="true"></i> <a href="{{ route('partialPaidInvoices') }}">{{ trans('layouts/sidebar.report.invoices') }} ({{ $partial_paid_count }})</a>
            </p>
        </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-100 bg-danger">
        <div class="card-body">
            <div class="clearfix">
            <div class="float-start">
                <span class="text-white">
                <i class="fa fa-xmark highlight-icon" aria-hidden="true"></i>
                </span>
            </div>
            <div class="float-end text-end">
                <p class="card-text text-white">{{ trans('layouts/sidebar.invoice.unpaid') }}</p>
                <h4 class="text-white">${{ $unpaid_sum }}</h4>
            </div>
            </div>
            <p class="text-white mt-3 pt-3 border-top border-white">
            <i class="fa fa-magnifying-glass me-1" aria-hidden="true"></i> <a href="{{ route('unpaidInvoices') }}">{{ trans('layouts/sidebar.report.invoices') }} ({{ $unpaid_count }})</a>
            </p>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mb-30">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <h5 class="card-title">{{ trans('index.row1_title') }}</h5>
                        <x-chartjs-component :chart="$chart1" />
                    </div>
                    <div class="col-xl-4 mt-3 mt-xl-0">
                        <h5 class="card-title">{{ trans('index.row2_title') }}</h5>
                        <div class="mt-20">
                            <div class="clearfix">
                                <p class="mb-10 float-start">{{ trans('layouts/sidebar.invoice.paid') }} &nbsp;</p>
                                <p class="mb-10 text-info float-end">{{ round($paid_count / $all_count * 100) }}%</p>
                            </div>
                            <div class="progress progress-small">
                                <div class="skill2-bar bg-success" role="progressbar" style="width: {{ round($paid_count / $all_count * 100) }}%" aria-valuenow="{{ round($paid_count / $all_count * 100) }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mt-20">
                            <div class="clearfix">
                                <p class="mb-10 float-start">{{ trans('layouts/sidebar.invoice.partial') }} &nbsp;</p>
                                <p class="mb-10 text-success float-end">{{ round($partial_paid_count / $all_count * 100) }}%</p>
                            </div>
                            <div class="progress progress-small">
                                <div class="skill2-bar bg-warning" role="progressbar" style="width: {{ round($partial_paid_count / $all_count * 100) }}%"
                                    aria-valuenow="{{ round($partial_paid_count / $all_count * 100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mt-20 mb-20">
                            <div class="clearfix">
                                <p class="mb-10 float-start">{{ trans('layouts/sidebar.invoice.unpaid') }} &nbsp;</p>
                                <p class="mb-10 text-secondary float-end">{{ round($unpaid_count / $all_count * 100) }}%</p>
                            </div>
                            <div class="progress progress-small">
                                <div class="skill2-bar bg-danger" role="progressbar" style="width: {{ round($unpaid_count / $all_count * 100) }}%"
                                    aria-valuenow="{{ round($unpaid_count / $all_count * 100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mt-40 mb-20">
                            <x-chartjs-component :chart="$chart2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <h5 class="mb-15 card-title pb-0 border-0">{{ trans('index.row3_title') }} </h5>
                <div class="table-responsive">
                    <table class="table center-aligned-table mb-0 table-hover">
                        <thead>
                            <tr class="text-dark">
                                <th>{{ trans('index.row3_table1') }}</th>
                                <th>{{ trans('index.row3_table2') }}</th>
                                <th>{{ trans('index.row3_table3') }}</th>
                                <th>{{ trans('index.row3_table4') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $section)
                                <tr>
                                    <td>{{ $section -> name }}</td>
                                    <td>{{ $section -> product -> count() }}</td>
                                    <td>{{ $section -> invoice -> count() }}</td>
                                    <td>${{ number_format($section -> invoice -> sum('total'), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
