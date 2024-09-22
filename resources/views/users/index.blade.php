@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('users/users.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('users') }}">{{ trans('users/users.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('users') }}">{{ trans('users/users.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('users/users.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @include('users.table')
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
                ajax: "{{ route('users') }}",
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'status', name: 'status' },
                        { data: 'roles_name', name: 'roles_name' },
                        { data: 'processes', name: 'processes', orderable: false, searchable: false},
                        ]
            });
        });
    </script>

    {{-- Add user --}}
    @if (Auth::user()->can('اضافة مستخدم') or Auth::user()->can('Add User'))
        <script>
            $('#addForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['name', 'email', 'password', 'password_confirm', 'status', 'role'];
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
                            $('#addForm #status').niceSelect('update');
                            $('#addForm #role').niceSelect('update');

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

    {{-- Delete user --}}
    @if (Auth::user()->can('حذف مستخدم') or Auth::user()->can('Delete User'))
        <script>
            /* Fetch section id to modal */
            $('body').on('click', '#deleteBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var name = $(this).data('name')
                var email = $(this).data('email')

                $('#deleteModal #id').val(id);
                $('#deleteModal #name').val(name + '  -  ' + email);
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

    {{-- Delete seleted users --}}
    @if (Auth::user()->can('حذف المستخدمين المختارين') or Auth::user()->can('Delete Selected Users'))
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
