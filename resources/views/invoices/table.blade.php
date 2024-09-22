@if (Auth::user()->can('إضافة فاتورة') or Auth::user()->can('Add Invoice'))
    <button type="button" class="button x-small" data-toggle="modal" data-target="#addModal">
        {{ trans('invoices/invoices.add_invoice') }}
    </button>
@endif

@if (Auth::user()->can('حذف الفواتير المختارة') or Auth::user()->can('Delete Selected Invoices'))
    <button type="button" class="button x-small ml-2" id="delete_all_btn">
        {{ trans('invoices/invoices.delete_selected') }}
    </button>
@endif

@if (Auth::user()->can('أرشفة الفواتير المختارة') or Auth::user()->can('Archive Selected Invoices'))
    <button type="button" class="button x-small ml-2" id="archive_all_btn">
        {{ trans('invoices/invoices.archive_selected') }}
    </button>
@endif

@if (Auth::user()->can('تصدير اكسيل') or Auth::user()->can('Excel Export'))
    <a type="button" href="{{ route('exportInvoices') }}" class="button x-small ml-2">
        {{ trans('invoices/invoices.export') }}
    </a>
@endif
<br><br>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered p-0"
        style="white-space: nowrap;">
        <thead>
            <tr>
                <th><input name="select_all" id="select_all" type="checkbox" onclick="CheckAll('box1', this)"></th>
                <th>#</th>
                <th>{{ trans('invoices/invoices.number') }}</th>
                <th>{{ trans('invoices/invoices.total') }}</th>
                <th>{{ trans('invoices/invoices.status') }}</th>
                <th>{{ trans('invoices/invoices.section') }}</th>
                <th>{{ trans('invoices/invoices.product') }}</th>
                <th>{{ trans('invoices/invoices.processes') }}</th>
            </tr>
        </thead>
        @include('invoices.modals')
    </table>
    <!-- Add Modal -->
    @if (Auth::user()->can('إضافة فاتورة') or Auth::user()->can('Add Invoice'))
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ trans('invoices/invoices.add_invoice') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" action="{{ route('addInvoice') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="number" class="mr-sm-2">{{ trans('invoices/invoices.number') }} :</label>
                                    <input type="text" id="number" name="number" class="form-control" >
                                    <label id="number_add_error" class="error ui red pointing label transition d-none" for="number"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="date" class="mr-sm-2">{{ trans('invoices/invoices.date') }} :</label>
                                    <input type="text" id="date" name="date" value="{{ date('Y-m-d') }}" class="form-control date-picker-default" >
                                    <label id="date_add_error" class="error ui red pointing label transition d-none" for="date"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="due_date" class="mr-sm-2">{{ trans('invoices/invoices.due_date') }} :</label>
                                    <input type="text" id="due_date" name="due_date" value="{{ date('Y-m-d') }}" class="form-control date-picker-default" >
                                    <label id="due_date_add_error" class="error ui red pointing label transition d-none" for="due_date"></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="section" class="mr-sm-2">{{ trans('invoices/invoices.section') }} :</label>
                                    <div class="box">
                                        <select id="section" class="fancyselect" name="section">
                                            <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section -> id }}">{{ $section -> name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label id="section_add_error" class="error ui red pointing label transition d-none" for="section"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="product" class="mr-sm-2">{{ trans('invoices/invoices.product') }} :</label>
                                    <div class="box">
                                        <select id="product" class="fancyselect" name="product">
                                            <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                        </select>
                                    </div>
                                    <label id="product_add_error" class="error ui red pointing label transition d-none" for="product"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="collection_amount" class="mr-sm-2">{{ trans('invoices/invoices.collection_amount') }} :</label>
                                    <input type="number" id="collection_amount" name="collection_amount" class="form-control" step=".01">
                                    <label id="collection_amount_add_error" class="error ui red pointing label transition d-none" for="collection_amount"></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="commission_amount" class="mr-sm-2">{{ trans('invoices/invoices.commission_amount') }} :</label>
                                    <input type="number" id="commission_amount" name="commission_amount" class="form-control" step=".01">
                                    <label id="commission_amount_add_error" class="error ui red pointing label transition d-none" for="commission_amount"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="discount" class="mr-sm-2">{{ trans('invoices/invoices.discount') }} :</label>
                                    <input type="number" id="discount" name="discount" class="form-control" value="0" step=".01">
                                    <label id="discount_add_error" class="error ui red pointing label transition d-none" for="discount"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="vat" class="mr-sm-2">{{ trans('invoices/invoices.vat') }} :</label>
                                    <div class="box">
                                        <select id="vat" class="fancyselect" name="vat">
                                            <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                            <option value="2.5%">2.5%</option>
                                            <option value="5%">5%</option>
                                            <option value="7.5%">7.5%</option>
                                            <option value="10%">10%</option>
                                        </select>
                                    </div>
                                    <label id="vat_add_error" class="error ui red pointing label transition d-none" for="vat"></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    <label for="vat_value" class="mr-sm-2">{{ trans('invoices/invoices.vat_value') }} :</label>
                                    <input type="number" id="vat_value" name="vat_value" class="form-control" readonly>
                                    <label id="vat_value_add_error" class="error ui red pointing label transition d-none" for="vat_value"></label>
                                </div>
                                <div class="col mt-2 mb-2">
                                    <label for="total" class="mr-sm-2">{{ trans('invoices/invoices.total') }} :</label>
                                    <input type="number" id="total" name="total" class="form-control" readonly>
                                    <label id="total_add_error" class="error ui red pointing label transition d-none" for="total"></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mt-2 mb-2">
                                    {{-- <div class="form-group custom-file"> --}}
                                        <label for="attachments" class="mr-sm-2">{{ trans('invoices/invoices.attachments') }} :</label>
                                        <input type="file" id="attachments" class="form-control" accept="image/jpg, image/jpeg, image/png, application/pdf" name="attachments">
                                    {{-- </div> --}}
                                    <label id="attachments_add_error" class="error ui red pointing label transition d-none" for="attachments"></label>
                                </div>
                            </div>

                            <div class="form-group mt-2 mb-2">
                                <label for="note">{{ trans('invoices/invoices.note') }}:</label>
                                <textarea id="note" name="note" class="form-control" rows="5" style="resize:none;"></textarea>
                                <label id="note_add_error" class="error ui red pointing label transition d-none" for="note"></label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('invoices/invoices.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('invoices/invoices.confirm') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Add Modal -->
</div>
