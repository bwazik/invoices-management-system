<!-- Edit Modal -->
@if (Auth::user()->can('تعديل قسم') or Auth::user()->can('Edit Section'))
    <div class="modal fade editModal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('sections/sections.edit_section') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('editSection') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="name_ar" class="mr-sm-2">{{ trans('sections/sections.name_ar') }} :</label>
                                <input type="text" id="name_ar" name="name_ar" value="" class="form-control" required>
                                <label id="name_ar_edit_error" class="error ui red pointing label transition d-none" for="name_ar"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="name_en" class="mr-sm-2">{{ trans('sections/sections.name_en') }} :</label>
                                <input type="text" id="name_en" name="name_en" value="" class="form-control" required>
                                <label id="name_en_edit_error" class="error ui red pointing label transition d-none" for="name_en"></label>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="note">{{ trans('sections/sections.note') }} :</label>
                            <textarea id="note" name="note" class="form-control" rows="5" style="resize:none;"></textarea>
                            <label id="note_edit_error" class="error ui red pointing label transition d-none" for="note"></label>
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
<!-- Edit Modal -->


<!-- Delete Modal -->
@if (Auth::user()->can('حذف قسم') or Auth::user()->can('Delete Section'))
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
                    <form id="deleteForm" action="{{ route('deleteSection') }}" method="POST">
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
@if (Auth::user()->can('حذف الأقسام المختارة') or Auth::user()->can('Delete Selected Sections'))
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
                    <form id="delete_selectedForm" action="{{ route('deleteSelectedSections') }}" method="POST">
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
