@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('users/users.title_edit') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('editUser', $user -> id) }}">{{ trans('users/users.pageTitle1_edit') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('editUser', $user -> id) }}">{{ trans('users/users.pageTitle1_edit') }}</a>
@endsection

@section('subTitle')
    {{ trans('users/users.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form id="editForm" action="{{ route('updateUser') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $user -> id }}">
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="name" class="mr-sm-2">{{ trans('users/users.name') }}:</label>
                                <input type="text" id="name" name="name" value="{{ $user -> name }}" class="form-control" required>
                                <label id="name_edit_error" class="error ui red pointing label transition d-none" for="name"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="email" class="mr-sm-2">{{ trans('users/users.email') }}:</label>
                                <input type="email" id="email" name="email" value="{{ $user -> email }}" class="form-control" required>
                                <label id="email_edit_error" class="error ui red pointing label transition d-none" for="email"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="password" class="mr-sm-2">{{ trans('users/users.password') }}:</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <label id="password_edit_error" class="error ui red pointing label transition d-none" for="password"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="password_confirm" class="mr-sm-2">{{ trans('users/users.password_confirm') }}:</label>
                                <input type="password" id="password_confirm" name="password_confirm" class="form-control">
                                <label id="password_confirm_edit_error" class="error ui red pointing label transition d-none" for="password_confirm"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="status" class="mr-sm-2">{{ trans('users/users.status') }} :</label>
                                <div class="box">
                                    <select id="status" class="fancyselect" name="status">
                                        <option selected disabled value="">{{ trans('users/users.choose') }}</option>
                                        <option value="1" @if ($user -> status == 1) selected @endif>{{ trans('users/users.active') }}</option>
                                        <option value="0" @if ($user -> status == 0) selected @endif>{{ trans('users/users.inactive') }}</option>
                                    </select>
                                </div>
                                <label id="status_edit_error" class="error ui red pointing label transition d-none" for="status"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="role" class="mr-sm-2">{{ trans('users/users.roles_name') }} :</label>
                                <div class="box">
                                    <select id="role" class="form-control" name="roles_name[]" multiple>
                                        @foreach ($roles as $role)
                                            <option @if (in_array($role -> id, $userRole)) selected @endif value="{{ $role -> getTranslation('name', 'en') }}">{{ $role -> name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label id="role_edit_error" class="error ui red pointing label transition d-none" for="role"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <button type="submit" class="btn btn-block btn-success">{{ trans('users/users.confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    {{-- Edit user --}}
    <script>
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            fields = ['name', 'email', 'password', 'password_confirm', 'status', 'role'];
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
                        window.location.href = '{{ route('users') }}';
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
