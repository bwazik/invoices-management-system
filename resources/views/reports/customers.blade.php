@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('reports/customers.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('customersReports') }}">{{ trans('reports/customers.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('customersReports') }}">{{ trans('reports/customers.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('reports/customers.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form id="customersSearch" action="{{ route('customersSearch') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="section" class="mr-sm-2">{{ trans('invoices/invoices.section') }} :</label>
                                <div class="box">
                                    <select id="section" class="fancyselect" name="section">
                                        <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section -> id }}">{{ $section -> name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label id="section_error" class="error ui red pointing label transition d-none" for="section"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="product" class="mr-sm-2">{{ trans('invoices/invoices.product') }} :</label>
                                <div class="box">
                                    <select id="product" class="fancyselect" name="product">
                                        <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                    </select>
                                </div>
                                <label id="product_error" class="error ui red pointing label transition d-none" for="product"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="start_date" class="mr-sm-2">{{ trans('reports/customers.start_date') }} :</label>
                                <input type="text" id="start_date" name="start_date" class="form-control date-picker-default" >
                                <label id="start_date_error" class="error ui red pointing label transition d-none" for="start_date"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="end_date" class="mr-sm-2">{{ trans('reports/customers.end_date') }} :</label>
                                <input type="text" id="end_date" name="end_date" class="form-control date-picker-default" >
                                <label id="end_date_error" class="error ui red pointing label transition d-none" for="end_date"></label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-success">{{ trans('invoices/invoices.confirm') }}</button>
                    </form>
                    <br><br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered p-0"
                            style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('invoices/invoices.number') }}</th>
                                    <th>{{ trans('invoices/invoices.total') }}</th>
                                    <th>{{ trans('invoices/invoices.status') }}</th>
                                    <th>{{ trans('invoices/invoices.section') }}</th>
                                    <th>{{ trans('invoices/invoices.product') }}</th>
                                    <th>{{ trans('invoices/invoices.processes') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#customersSearch #section').on('change', function() {
                var section = $(this).val();
                if (section) {
                    $.ajax({
                        url: "{{ URL::to('invoices/sections') }}/" + section,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#customersSearch #product').empty();
                            $('#customersSearch #product').append(
                                '<option selected disabled value="">{{ trans('products/products.choose') }}...</option>'
                                );
                            $.each(data, function(key, value) {
                                $('#customersSearch #product').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                            $('#customersSearch #product').niceSelect('update');
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });

        $('#customersSearch').on('submit', function(e) {
            e.preventDefault();

            fields = ['section', 'product', 'start_date', 'end_date'];
            $.each(fields, function(key, field) {
                $('#customersSearch #' + field + '_error').addClass('d-none');
            });
            var section = $("#customersSearch #section").val();
            var product = $("#customersSearch #product").val();
            var start_date = $("#customersSearch #start_date").val();
            var end_date = $("#customersSearch #end_date").val();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy : true,
                ajax: {
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            "section": section,
                            "product": product,
                            "start_date": start_date,
                            "end_date": end_date,
                        },
                        error: function(error) {
                            var response = $.parseJSON(error.responseText);
                            $.each(response.errors, function(key, val) {
                                $('#customersSearch #' + key + '_error').removeClass('d-none');
                                $('#customersSearch #' + key + '_error').text(val[0]);
                            });
                        },
                    },
                columns: [
                        { data: 'id', name: 'id' },
                        { data: 'number', name: 'number' },
                        { data: 'total', name: 'total' },
                        { data: 'status', name: 'status' },
                        { data: 'section', name: 'section' },
                        { data: 'product', name: 'product' },
                        { data: 'details', name: 'details', orderable: false, searchable: false },
                        ]
            });
        });
    </script>

@endsection
