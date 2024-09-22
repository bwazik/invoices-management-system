@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('sections/sections.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('sections') }}">{{ trans('sections/sections.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('sections') }}">{{ trans('sections/sections.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('sections/sections.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @include('sections.table')
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
                ajax: "{{ route('sections') }}",
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'note', name: 'note', orderable: false, searchable: false },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'processes', name: 'processes', orderable: false, searchable: false},
                        ]
            });
        });
    </script>

    {{-- Add section --}}
    @if (Auth::user()->can('إضافة قسم') or Auth::user()->can('Add Section'))
        <script>
            $('#addForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['name_ar', 'name_en', 'note'];
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

    {{-- Edit section --}}
    @if (Auth::user()->can('تعديل قسم') or Auth::user()->can('Edit Section'))
        <script>
            /* Fetch section id to modal */
            $('body').on('click', '#editBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var name_ar = $(this).data('name_ar')
                var name_en = $(this).data('name_en')
                var note = $(this).data('note')

                $('#editModal #id').val(id);
                $('#editModal #name_ar').val(name_ar);
                $('#editModal #name_en').val(name_en);
                $('#editModal #note').val(note);
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['name_ar', 'name_en', 'note'];
                $.each(fields, function(key, field) {
                    $('#' + field + '_edit_error').addClass('d-none');
                });

                var formData = $('#editForm')[0];
                var id = $('#editModal #id').val();
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
                            toastr.success(response.success)
                            $('.editModal').modal('hide')
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

    {{-- Delete section --}}
    @if (Auth::user()->can('حذف قسم') or Auth::user()->can('Delete Section'))
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

    {{-- Delete seleted sections --}}
    @if (Auth::user()->can('حذف الأقسام المختارة') or Auth::user()->can('Delete Selected Sections'))
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
