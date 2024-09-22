@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('roles/roles.title_edit') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('roles') }}">{{ trans('roles/roles.pageTitle1_edit') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('roles') }}">{{ trans('roles/roles.pageTitle1_edit') }}</a>
@endsection

@section('subTitle')
    {{ trans('roles/roles.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form id="editForm" action="{{ route('updateRole', $role -> id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $role -> id }}">
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="name_ar" class="mr-sm-2">{{ trans('roles/roles.name_ar') }} :</label>
                                <input type="text" id="name_ar" name="name_ar" value="{{ $role->getTranslation('name', 'ar') }}" class="form-control" required>
                                <label id="name_ar_edit_error" class="error ui red pointing label transition d-none" for="name_ar"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="name_en" class="mr-sm-2">{{ trans('roles/roles.name_en') }} :</label>
                                <input type="text" id="name_en" name="name_en" value="{{ $role->getTranslation('name', 'en') }}" class="form-control" required>
                                <label id="name_en_edit_error" class="error ui red pointing label transition d-none" for="name_en"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="permission" class="mr-sm-2">{{ trans('roles/roles.permissions') }}:</label>
                                <br>
                                <label id="permission_edit_error" class="error ui red pointing label transition d-none" for="permission"></label>
                                @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" id="permission" name="permission[]" @if (in_array($permission -> id, $rolePermissions)) checked @endif value="{{ $permission -> name }}" class="form-check-input">
                                    <label class="text-success form-check-label">{{ $permission -> name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <button type="submit" class="btn btn-block btn-success">{{ trans('roles/roles.confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- Edit Role --}}
    <script>
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            fields = ['name_ar', 'name_en', 'permission'];
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
                        window.location.href = '{{ route('roles') }}';
                        toastr.success(response.success)
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
@endsection
