@if (Auth::user()->can('اضافة مستخدم') or Auth::user()->can('Add User'))
    <button type="button" class="button x-small" data-toggle="modal" data-target="#addModal">
        {{ trans('users/users.add_user') }}
    </button>
@endif

@if (Auth::user()->can('حذف المستخدمين المختارين') or Auth::user()->can('Delete Selected Users'))
    <button type="button" class="button x-small ml-2" id="delete_all_btn">
        {{ trans('users/users.delete_selected') }}
    </button>
@endif
<br><br>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered p-0"
        style="white-space: nowrap;">
        <thead>
            <tr>
                <th><input name="select_all" id="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                <th>#</th>
                <th>{{ trans('users/users.name') }}</th>
                <th>{{ trans('users/users.email') }}</th>
                <th>{{ trans('users/users.status') }}</th>
                <th>{{ trans('users/users.roles_name') }}</th>
                <th>{{ trans('users/users.processes') }}</th>
            </tr>
        </thead>
        @include('users.modals')
    </table>
    <!-- Add Modal -->
    @if (Auth::user()->can('اضافة مستخدم') or Auth::user()->can('Add User'))
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ trans('users/users.add_user') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="{{ route('addUser') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="name" class="mr-sm-2">{{ trans('users/users.name') }}:</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                    <label id="name_add_error" class="error ui red pointing label transition d-none" for="name"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="email" class="mr-sm-2">{{ trans('users/users.email') }}:</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                    <label id="email_add_error" class="error ui red pointing label transition d-none" for="email"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="password" class="mr-sm-2">{{ trans('users/users.password') }}:</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <label id="password_add_error" class="error ui red pointing label transition d-none" for="password"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="password_confirm" class="mr-sm-2">{{ trans('users/users.password_confirm') }}:</label>
                                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                                    <label id="password_confirm_add_error" class="error ui red pointing label transition d-none" for="password_confirm"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="status" class="mr-sm-2">{{ trans('users/users.status') }} :</label>
                                    <div class="box">
                                        <select id="status" class="fancyselect" name="status">
                                            <option selected disabled value="">{{ trans('users/users.choose') }}</option>
                                            <option value="1">{{ trans('users/users.active') }}</option>
                                            <option value="0">{{ trans('users/users.inactive') }}</option>
                                        </select>
                                    </div>
                                    <label id="status_add_error" class="error ui red pointing label transition d-none" for="status"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="role" class="mr-sm-2">{{ trans('users/users.roles_name') }} :</label>
                                    <div class="box">
                                        <select id="role" class="form-control" name="role[]" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role -> getTranslation('name', 'en') }}">{{ $role -> name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label id="role_add_error" class="error ui red pointing label transition d-none" for="role"></label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('users/users.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('users/users.confirm') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Add Modal -->
</div>
