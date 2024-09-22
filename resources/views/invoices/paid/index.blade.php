@extends('layouts.master')

@section('css')

@endsection

@section('mainTitle')
    {{ trans('invoices/invoices.paidinvoices') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('paidInvoices') }}">{{ trans('invoices/invoices.paidinvoices') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('paidInvoices') }}">{{ trans('invoices/invoices.paidinvoices') }}</a>
@endsection

@section('subTitle')
    <a href="{{ route('invoices') }}">{{ trans('invoices/invoices.pageTitle1') }}</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @include('invoices.paid.table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- Show table data --}}
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('paidInvoices') }}",
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
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

    {{-- Edit invoice --}}
    @if (Auth::user()->can('تعديل فاتورة') or Auth::user()->can('Edit Invoice'))
        <script>
            /* Fetch product id to modal */
            $('body').on('click', '#editBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id') , number = $(this).data('number') , date = $(this).data('date') , due_date = $(this).data('due_date')
                , section = $(this).data('section') , product = $(this).data('product')
                , collection_amount = $(this).data('collection_amount') ,commission_amount = $(this).data('commission_amount')
                , discount = $(this).data('discount') , vat = $(this).data('vat') , vat_value = $(this).data('vat_value')
                , total = $(this).data('total') , note = $(this).data('note');

                $('#editModal #id').val(id);
                $('#editModal #number').val(number);
                $('#editModal #date').val(date);
                $('#editModal #due_date').val(due_date);
                $('#editModal #section').val(section).niceSelect('update');
                $('#editModal #product').val(product).niceSelect('update');
                $('#editModal #collection_amount').val(collection_amount);
                $('#editModal #commission_amount').val(commission_amount);
                $('#editModal #discount').val(discount);
                $('#editModal #vat').val(vat).niceSelect('update');
                $('#editModal #vat_value').val(vat_value);
                $('#editModal #total').val(total);
                $('#editModal #note').val(note);

            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['number', 'date', 'due_date', 'section', 'product',
                            'collection_amount','commission_amount',
                            'discount', 'vat', 'vat_value',
                            'total', 'note'];

                $.each(fields, function(key, field) {
                    $('#' + field + '_edit_error').addClass('d-none');
                });

                var formData = $('#editForm')[0];
                var form = new FormData(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,

                    success: function(response) {
                        if(response.success) {
                            $.each(fields, function(key, field) {
                                $('#editForm #' + field).val('');
                            });
                            $('#editForm #section').niceSelect('update');
                            $('#editForm #product').niceSelect('update');
                            $('#editForm #vat').niceSelect('update');

                            toastr.success(response.success)
                            $('#editModal').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }
                    },
                    error: function(error) {
                        var response = $.parseJSON(error.responseText);
                        $.each(response.errors, function(key, val) {
                            $('#' + key + '_edit_error').removeClass('d-none');
                            $('#' + key + '_edit_error').text(val[0]);
                        });
                    },
                });
            });
        </script>
    @endif

    {{-- Delete invoice --}}
    @if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice'))
        <script>
            /* Fetch product id to modal */
            $('body').on('click', '#deleteBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var number = $(this).data('number')

                $('#deleteModal #id').val(id);
                $('#deleteModal #number').val(number);
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#deleteForm')[0];
                var form = new FormData(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,

                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.success)
                            $('.deleteModal').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }else {
                            toastr.error(response.error)
                            $('.deleteModal').modal('hide')
                        }
                    },
                });
            });
        </script>
    @endif

    {{-- Delete seleted invoices --}}
    @if (Auth::user()->can('حذف الفواتير المختارة') or Auth::user()->can('Delete Selected Invoices'))
        <script>
            $('#delete_selectedForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#delete_selectedForm')[0];
                var form = new FormData(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,

                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.success)
                            $('#delete_selected').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }else {
                            toastr.error(response.error)
                            $('#delete_selected').modal('hide')
                        }
                    },
                });
            });
        </script>
    @endif

    {{-- Change invoice payment status --}}
    @if (Auth::user()->can('تعديل حالة الدفع') or Auth::user()->can('Change Payment Status'))
        <script>
            /* Fetch product id to modal */
            $('body').on('click', '#paymentBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id') , number = $(this).data('number')
                , section = $(this).data('section') , product = $(this).data('product')
                , total = $(this).data('total');

                $('#paymentModal #id').val(id);
                $('#paymentModal #number').val(number);
                $('#paymentModal #section').val(section).niceSelect('update');
                $('#paymentModal #product').val(product).niceSelect('update');
                $('#paymentModal #total').val(total);
                $('#paymentModal #note').val('-');
            });

            $('#paymentForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['payment_status', 'payment_date'];

                $.each(fields, function(key, field) {
                    $('#' + field + '_error').addClass('d-none');
                });

                var formData = $('#paymentForm')[0];
                var form = new FormData(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,

                    success: function(response) {
                        if(response.success) {
                            $.each(fields, function(key, field) {
                                $('#paymentForm #' + field).val('');
                            });

                            toastr.success(response.success)
                            $('#paymentModal').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }
                    },
                    error: function(error) {
                        var response = $.parseJSON(error.responseText);
                        $.each(response.errors, function(key, val) {
                            $('#' + key + '_error').removeClass('d-none');
                            $('#' + key + '_error').text(val[0]);
                        });
                    },
                });
            });
        </script>
    @endif

    {{-- Archive invoice --}}
    @if (Auth::user()->can('أرشفة فاتورة') or Auth::user()->can('Archive Invoice'))
        <script>
            /* Fetch product id to modal */
            $('body').on('click', '#archiveBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var number = $(this).data('number')

                $('#archiveModal #id').val(id);
                $('#archiveModal #number').val(number);
            });

            $('#archiveForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#archiveForm')[0];
                var form = new FormData(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,

                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.success)
                            $('.archiveModal').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }else {
                            toastr.error(response.error)
                            $('.archiveModal').modal('hide')
                        }
                    },
                });
            });
        </script>
    @endif

    {{-- Archive Selected invoices --}}
    @if (Auth::user()->can('أرشفة الفواتير المختارة') or Auth::user()->can('Archive Selected Invoices'))
        <script>
            $('#archive_selectedForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#archive_selectedForm')[0];
                var form = new FormData(formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,

                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.success)
                            $('#archive_selected').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }else {
                            toastr.error(response.error)
                            $('#archive_selected').modal('hide')
                        }
                    },
                });
            });
        </script>
    @endif
@endsection
