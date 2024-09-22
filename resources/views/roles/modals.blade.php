<!-- Delete Modal -->
@if (Auth::user()->can('حذف رتبة') or Auth::user()->can('Delete Role'))
    <div class="modal fade deleteModal" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('sections/sections.delete_section') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteForm" action="{{ route('deleteRole') }}" method="POST">
                        @csrf
                        {{ trans('sections/sections.delete_warning') }}
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="text" disabled
                                    value=""
                                    id="name"
                                    class="form-control">
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('sections/sections.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('sections/sections.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Delete Modal -->

<!-- Delete Selected Modal -->
@if (Auth::user()->can('حذف الرتب المختارة') or Auth::user()->can('Delete Selected Roles'))
    <div class="modal fade" id="delete_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('sections/sections.delete_selected') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_selectedForm" action="{{ route('deleteSelectedRoles') }}" method="POST">
                        @csrf
                        {{ trans('sections/sections.delete_warning') }}
                        <input id="delete_selected_id" type="hidden" value=""
                            name="delete_selected_id" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('sections/sections.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('sections/sections.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Delete Selected Modal -->
