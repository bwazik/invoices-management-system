@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('reports/invoices.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('invoicesReports') }}">{{ trans('reports/invoices.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('invoicesReports') }}">{{ trans('reports/invoices.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('reports/invoices.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="tab tab-vertical">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">{{ trans('reports/invoices.dateSearch') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">{{ trans('reports/invoices.numberSearch') }} </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <form id="dateSearch" action="{{ route('dateSearch') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col mt-2 mb-2">
                                            <label for="status" class="mr-sm-2">{{ trans('invoices/invoices.status') }} :</label>
                                            <div class="box">
                                                <select id="status" class="fancyselect" name="status">
                                                    <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                                    <option value="4">{{ trans('reports/invoices.all') }}</option>
                                                    <option value="1">{{ trans('invoices/invoices.paid') }}</option>
                                                    <option value="2">{{ trans('invoices/invoices.unpaid') }}</option>
                                                    <option value="3">{{ trans('invoices/invoices.partial') }}</option>
                                                </select>
                                            </div>
                                            <label id="status_error" class="error ui red pointing label transition d-none" for="status"></label>
                                        </div>
                                        <div class="col mt-2 mb-2">
                                            <label for="start_date" class="mr-sm-2">{{ trans('reports/invoices.start_date') }} :</label>
                                            <input type="text" id="start_date" name="start_date" class="form-control date-picker-default" required>
                                            <label id="start_date_error" class="error ui red pointing label transition d-none" for="start_date"></label>
                                        </div>
                                        <div class="col mt-2 mb-2">
                                            <label for="end_date" class="mr-sm-2">{{ trans('reports/invoices.end_date') }} :</label>
                                            <input type="text" id="end_date" name="end_date" class="form-control date-picker-default" required>
                                            <label id="end_date_error" class="error ui red pointing label transition d-none" for="end_date"></label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-success">{{ trans('invoices/invoices.confirm') }}</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                <form id="numberSearch" action="{{ route('numberSearch') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col mt-2 mb-2">
                                            <label for="number" class="mr-sm-2">{{ trans('invoices/invoices.number') }} :</label>
                                            <input type="text" id="number" name="number" class="form-control" required>
                                            <label id="number_error" class="error ui red pointing label transition d-none" for="number"></label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-success">{{ trans('invoices/invoices.confirm') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
        $('#numberSearch').on('submit', function(e) {
            e.preventDefault();

            $('#numberSearch #number_error').addClass('d-none');
            $('#numberSearch #number_error').removeClass('d-block');
            var number = $("#numberSearch #number").val();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy : true,
                ajax: {
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            "number": number,
                        },
                        error: function(error) {
                            var response = $.parseJSON(error.responseText);
                            $.each(response.errors, function(key, val) {
                                $('#numberSearch #' + key + '_error').removeClass('d-none');
                                $('#numberSearch #' + key + '_error').addClass('d-block');
                                $('#numberSearch #' + key + '_error').text(val[0]);
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
                        ],
            });
        });

        $('#dateSearch').on('submit', function(e) {
            e.preventDefault();

            fields = ['status', 'start_date', 'end_date'];
            $.each(fields, function(key, field) {
                $('#dateSearch #' + field + '_error').addClass('d-none');
            });
            var status = $("#dateSearch #status").val();
            var start_date = $("#dateSearch #start_date").val();
            var end_date = $("#dateSearch #end_date").val();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy : true,
                ajax: {
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: {
                            _token: "{{ csrf_token() }}",
                            "status": status,
                            "start_date": start_date,
                            "end_date": end_date,
                        },
                        error: function(error) {
                            var response = $.parseJSON(error.responseText);
                            $.each(response.errors, function(key, val) {
                                $('#dateSearch #' + key + '_error').removeClass('d-none');
                                $('#dateSearch #' + key + '_error').text(val[0]);
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
