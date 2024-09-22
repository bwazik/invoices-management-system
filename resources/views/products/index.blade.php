@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('products/products.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('products') }}">{{ trans('products/products.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('products') }}">{{ trans('products/products.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('products/products.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    @include('products.table')
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
                ajax: "{{ route('products') }}",
                columns: [
                        { data: 'selectbox', name: 'selectbox', orderable: false, searchable: false },
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'note', name: 'note', orderable: false, searchable: false },
                        { data: 'section', name: 'section' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'processes', name: 'processes', orderable: false, searchable: false},
                        ]
            });
        });
    </script>

    {{-- Add product --}}
    @if (Auth::user()->can('إضافة منتج') or Auth::user()->can('Add Product'))
        <script>
            $('#addForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['name_ar', 'name_en', 'note', 'section'];
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

    {{-- Edit product --}}
    @if (Auth::user()->can('تعديل منتج') or Auth::user()->can('Edit Product'))
        <script>
            /* Fetch product id to modal */
            $('body').on('click', '#editBtn', function(e) {
                e.preventDefault();

                var id = $(this).data('id')
                var name_ar = $(this).data('name_ar')
                var name_en = $(this).data('name_en')
                var note = $(this).data('note')
                var section = $(this).data('section')

                // $('#editModal #section').next().find('li').removeClass('selected')
                // var section_text = $('#editModal #section').next().find('li[data-value=' + section + ']').text()




                $('#editModal #id').val(id);
                $('#editModal #name_ar').val(name_ar);
                $('#editModal #name_en').val(name_en);
                $('#editModal #note').val(note);
                $('#editModal #section').val(section).niceSelect('update');
                // $('#editModal #section').next().find('li[data-value=' + section + ']').addClass('selected')
                // $('#editModal #section').next().find('.current').html(section_text)
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                fields = ['name_ar', 'name_en', 'note', 'section'];
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

    {{-- Delete product --}}
    @if (Auth::user()->can('حذف منتج') or Auth::user()->can('Delete Product'))
        <script>
            /* Fetch product id to modal */
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

    {{-- Delete seleted products --}}
    @if (Auth::user()->can('حذف المنتجات المختارة') or Auth::user()->can('Delete Selected Products'))
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
