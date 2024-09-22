<!-- Edit Modal -->
@if (Auth::user()->can('تعديل منتج') or Auth::user()->can('Edit Product'))
    <div class="modal fade editModal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('products/products.edit_product') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('editProduct') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="name_ar" class="mr-sm-2">{{ trans('products/products.name_ar') }} :</label>
                                <input type="text" id="name_ar" name="name_ar" value="" class="form-control" required>
                                <label id="name_ar_edit_error" class="error ui red pointing label transition d-none" for="name_ar"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="name_en" class="mr-sm-2">{{ trans('products/products.name_en') }} :</label>
                                <input type="text" id="name_en" name="name_en" value="" class="form-control" required>
                                <label id="name_en_edit_error" class="error ui red pointing label transition d-none" for="name_en"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="section" class="mr-sm-2">{{ trans('products/products.section') }} :</label>
                                <div class="box">
                                    <select id="section" class="fancyselect" name="section">
                                        @foreach ($sections as $section)
                                            <option value="{{ $section -> id }}"> {{ $section -> name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label id="section_edit_error" class="error ui red pointing label transition d-none" for="section"></label>
                            </div>
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <label for="note">{{ trans('products/products.note') }} :</label>
                            <textarea id="note" name="note" class="form-control" rows="5" style="resize:none;"></textarea>
                            <label id="note_edit_error" class="error ui red pointing label transition d-none" for="note"></label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('products/products.close') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('products/products.confirm') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Edit Modal -->


<!-- Delete Modal -->
@if (Auth::user()->can('حذف منتج') or Auth::user()->can('Delete Product'))
    <div class="modal fade deleteModal" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('products/products.delete_product') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteForm" action="{{ route('deleteProduct') }}" method="POST">
                        @csrf
                        {{ trans('products/products.delete_warning') }}
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
                            data-dismiss="modal">{{ trans('products/products.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('products/products.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Delete Modal -->

<!-- Delete Selected Modal -->
@if (Auth::user()->can('حذف المنتجات المختارة') or Auth::user()->can('Delete Selected Products'))
    <div class="modal fade" id="delete_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('products/products.delete_selected') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_selectedForm" action="{{ route('deleteSelectedProducts') }}" method="POST">
                        @csrf
                        {{ trans('products/products.delete_warning') }}
                        <input id="delete_selected_id" type="hidden" value=""
                            name="delete_selected_id" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('products/products.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('products/products.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Delete Selected Modal -->
