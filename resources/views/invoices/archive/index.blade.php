@extends('layouts.master')

@section('css')

@endsection

@section('mainTitle')
    {{ trans('invoices/archive.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('invoicesArchive') }}">{{ trans('invoices/archive.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('invoicesArchive') }}">{{ trans('invoices/archive.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('invoices/archive.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @include('invoices.archive.table')
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
                ajax: "{{ route('invoicesArchive') }}",
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

    {{-- Unarchive invoice --}}
    @if (Auth::user()->can('إلغاء أرشفة فاتورة') or Auth::user()->can('Unarchive Invoice'))
        <script>
            /* Fetch product id to modal */
            $('body').on('click', '#unarchiveBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var number = $(this).data('number')

                $('#unarchiveModal #id').val(id);
                $('#unarchiveModal #number').val(number);
            });

            $('#unarchiveForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#unarchiveForm')[0];
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
                            $('.unarchiveModal').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }else {
                            toastr.error(response.error)
                            $('.unarchiveModal').modal('hide')
                        }
                    },
                });
            });
        </script>
    @endif

    {{-- Unarchive selected invoice --}}
    @if (Auth::user()->can('إالغاء أرشفة الفواتير المختارة') or Auth::user()->can('Unarchive Invoice'))
        <script>
            $('#unarchive_selectedForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $('#unarchive_selectedForm')[0];
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
                            $('#unarchive_selected').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }else {
                            toastr.error(response.error)
                            $('#unarchive_selected').modal('hide')
                        }
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
@endsection
