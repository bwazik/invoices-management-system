@if (Auth::user()->can('إضافة منتج') or Auth::user()->can('Add Product'))
    <button type="button" class="button x-small" data-toggle="modal" data-target="#addModal">
        {{ trans('products/products.add_product') }}
    </button>
@endif

@if (Auth::user()->can('حذف المنتجات المختارة') or Auth::user()->can('Delete Selected Products'))
    <button type="button" class="button x-small ml-2" id="delete_all_btn">
        {{ trans('products/products.delete_selected') }}
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
                <th>{{ trans('products/products.name') }}</th>
                <th>{{ trans('products/products.note') }}</th>
                <th>{{ trans('products/products.section') }}</th>
                <th>{{ trans('products/products.created_at') }}</th>
                <th>{{ trans('products/products.processes') }}</th>
            </tr>
        </thead>
        @include('products.modals')
    </table>

    <!-- Add Modal -->
    @if (Auth::user()->can('إضافة منتج') or Auth::user()->can('Add Product'))
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ trans('products/products.add_product') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="{{ route('addProduct') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="name_ar" class="mr-sm-2">{{ trans('products/products.name_ar') }} :</label>
                                    <input type="text" id="name_ar" name="name_ar" class="form-control" >
                                    <label id="name_ar_add_error" class="error ui red pointing label transition d-none" for="name_ar"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="name_en" class="mr-sm-2">{{ trans('products/products.name_en') }} :</label>
                                    <input type="text" id="name_en" name="name_en" class="form-control" >
                                    <label id="name_en_add_error" class="error ui red pointing label transition d-none" for="name_en"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="section" class="mr-sm-2">{{ trans('products/products.section') }} :</label>
                                    <div class="box">
                                        <select id="section" class="fancyselect" name="section">
                                            <option selected disabled value="">{{ trans('products/products.choose') }}</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section -> id }}">{{ $section -> name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label id="section_add_error" class="error ui red pointing label transition d-none" for="section"></label>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-2">
                                <label for="note">{{ trans('products/products.note') }}:</label>
                                <textarea id="note" name="note" class="form-control" rows="5" style="resize:none;"></textarea>
                                <label id="note_add_error" class="error ui red pointing label transition d-none" for="note"></label>
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
    <!-- Add Modal -->
</div>
