@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('roles/roles.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('roles') }}">{{ trans('roles/roles.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('roles') }}">{{ trans('roles/roles.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('roles/roles.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @include('roles.table')
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
                ajax: "{{ route('roles') }}",
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'processes', name: 'processes', orderable: false, searchable: false},
                        ]
            });
        });
    </script>

    {{-- Add Role --}}
    @if (Auth::user()->can('اضافة رتبة') or Auth::user()->can('Add Role'))
        <script>
            $('#addForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['name_ar', 'name_en', 'permission'];
                $.each(fields, function(key, field) {
                    $('#addForm #' + field + '_add_error').addClass('d-none');
                });


                var formData = $('#addForm')[0];
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
                                $('#addForm #' + field).val('');
                            });
                            $('#addForm #permission').prop('checked', false);
                            toastr.success(response.success)
                            $('#addModal').modal('hide')
                            $('#datatable').DataTable().ajax.reload(null, false)
                        }
                    },
                    error: function(error) {
                        var response = $.parseJSON(error.responseText);
                        $.each(response.errors, function(key, val) {
                            $('#addForm #' + key + '_add_error').removeClass('d-none');
                            $('#addForm #' + key + '_add_error').text(val[0]);
                        });
                    },
                });
            });
        </script>
    @endif

    {{-- Delete Role --}}
    @if (Auth::user()->can('حذف رتبة') or Auth::user()->can('Delete Role'))
        <script>
            /* Fetch section id to modal */
            $('body').on('click', '#deleteBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var name_ar = $(this).data('name_ar')
                var name_en = $(this).data('name_en')

                $('#deleteModal #id').val(id);
                $('#deleteModal #name').val(name_ar + '  -  ' + name_en);
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

    {{-- Delete seleted Roles --}}
    @if (Auth::user()->can('حذف الرتب المختارة') or Auth::user()->can('Delete Selected Roles'))
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
