@if (Auth::user()->can('اضافة رتبة') or Auth::user()->can('Add Role'))
    <button type="button" class="button x-small" data-toggle="modal" data-target="#addModal">
        {{ trans('roles/roles.add_role') }}
    </button>
@endif

@if (Auth::user()->can('حذف الرتب المختارة') or Auth::user()->can('Delete Selected Roles'))
    <button type="button" class="button x-small ml-2" id="delete_all_btn">
        {{ trans('roles/roles.delete_selected') }}
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
                <th>{{ trans('roles/roles.name') }}</th>
                <th>{{ trans('roles/roles.processes') }}</th>
            </tr>
        </thead>
        @include('roles.modals')
    </table>
    <!-- Add Modal -->
    @if (Auth::user()->can('اضافة رتبة') or Auth::user()->can('Add Role'))
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ trans('roles/roles.add_role') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="{{ route('addRole') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="name_ar" class="mr-sm-2">{{ trans('roles/roles.name_ar') }}:</label>
                                    <input type="text" id="name_ar" name="name_ar" class="form-control" required>
                                    <label id="name_ar_add_error" class="error ui red pointing label transition d-none" for="name_ar"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="name_en" class="mr-sm-2">{{ trans('roles/roles.name_en') }}:</label>
                                    <input type="text" id="name_en" name="name_en" class="form-control" required>
                                    <label id="name_en_add_error" class="error ui red pointing label transition d-none" for="name_en"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="permission" class="mr-sm-2">{{ trans('roles/roles.permissions') }}:</label>
                                    <br>
                                    <label id="permission_add_error" class="error ui red pointing label transition d-none" for="permission"></label>
                                    @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" id="permission" name="permission[]" value="{{ $permission -> name }}" class="form-check-input">
                                        <label class="text-success form-check-label">{{ $permission -> name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('roles/roles.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('roles/roles.confirm') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Add Modal -->
</div>
