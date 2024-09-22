<!-- Edit Modal -->
@if (Auth::user()->can('تعديل فاتورة') or Auth::user()->can('Edit Invoice'))
    <div class="modal fade editModal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.edit_invoice') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="{{ route('editInvoice') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="number" class="mr-sm-2">{{ trans('invoices/invoices.number') }} :</label>
                                <input type="text" id="number" name="number" class="form-control" >
                                <label id="number_edit_error" class="error ui red pointing label transition d-none" for="number"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="date" class="mr-sm-2">{{ trans('invoices/invoices.date') }} :</label>
                                <input type="text" id="date" name="date" value="{{ date('Y-m-d') }}" class="form-control date-picker-default" >
                                <label id="date_edit_error" class="error ui red pointing label transition d-none" for="date"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="due_date" class="mr-sm-2">{{ trans('invoices/invoices.due_date') }} :</label>
                                <input type="text" id="due_date" name="due_date" value="{{ date('Y-m-d') }}" class="form-control date-picker-default" >
                                <label id="due_date_edit_error" class="error ui red pointing label transition d-none" for="due_date"></label>
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
                                <label id="section_edit_error" class="error ui red pointing label transition d-none" for="section"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="product" class="mr-sm-2">{{ trans('invoices/invoices.product') }} :</label>
                                <div class="box">
                                    <select id="product" class="fancyselect" name="product">
                                        <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                        @foreach ($products as $product)
                                        <option value="{{ $product -> id }}">{{ $product -> name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label id="product_edit_error" class="error ui red pointing label transition d-none" for="product"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="collection_amount" class="mr-sm-2">{{ trans('invoices/invoices.collection_amount') }} :</label>
                                <input type="number" id="collection_amount" name="collection_amount" class="form-control" step=".01">
                                <label id="collection_amount_edit_error" class="error ui red pointing label transition d-none" for="collection_amount"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="commission_amount" class="mr-sm-2">{{ trans('invoices/invoices.commission') }} :</label>
                                <input type="number" id="commission_amount" name="commission_amount" class="form-control" step=".01">
                                <label id="commission_amount_edit_error" class="error ui red pointing label transition d-none" for="commission_amount"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="discount" class="mr-sm-2">{{ trans('invoices/invoices.discount') }} :</label>
                                <input type="number" id="discount" name="discount" class="form-control" value="0" step=".01">
                                <label id="discount_edit_error" class="error ui red pointing label transition d-none" for="discount"></label>
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
                                <label id="vat_edit_error" class="error ui red pointing label transition d-none" for="vat"></label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="vat_value" class="mr-sm-2">{{ trans('invoices/invoices.vat_value') }} :</label>
                                <input type="number" id="vat_value" name="vat_value" class="form-control" readonly>
                                <label id="vat_value_edit_error" class="error ui red pointing label transition d-none" for="vat_value"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="total" class="mr-sm-2">{{ trans('invoices/invoices.total') }} :</label>
                                <input type="number" id="total" name="total" class="form-control" readonly>
                                <label id="total_edit_error" class="error ui red pointing label transition d-none" for="total"></label>
                            </div>
                        </div>

                        <div class="form-group mt-2 mb-2">
                            <label for="note">{{ trans('invoices/invoices.note') }}:</label>
                            <textarea id="note" name="note" class="form-control" rows="5" style="resize:none;"></textarea>
                            <label id="note_edit_error" class="error ui red pointing label transition d-none" for="note"></label>
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
<!-- Edit Modal -->

<!-- Delete Modal -->
@if (Auth::user()->can('حذف فاتورة') or Auth::user()->can('Delete Invoice'))
    <div class="modal fade deleteModal" id="deleteModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.delete_invoice') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteForm" action="{{ route('deleteInvoice') }}" method="POST">
                        @csrf
                        {{ trans('invoices/invoices.delete_warning') }}
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="text" disabled
                                    value=""
                                    id="number"
                                    class="form-control">
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('invoices/invoices.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('invoices/invoices.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Delete Modal -->

<!-- Delete Selected Modal -->
@if (Auth::user()->can('حذف الفواتير المختارة') or Auth::user()->can('Delete Selected Invoices'))
    <div class="modal fade" id="delete_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.delete_selected') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_selectedForm" action="{{ route('deleteSelectedInvoices') }}" method="POST">
                        @csrf
                        {{ trans('invoices/invoices.delete_warning') }}
                        <input id="delete_selected_id" type="hidden" value=""
                            name="delete_selected_id" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('invoices/invoices.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('invoices/invoices.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Delete Selected Modal -->

<!-- Payment Modal -->
@if (Auth::user()->can('تعديل حالة الدفع') or Auth::user()->can('Change Payment Status'))
    <div class="modal fade paymentModal" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.payment') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm" action="{{ route('changePaymentStatus') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="" readonly>
                        <select id="section" class="d-none" name="section">@foreach ($sections as $section) <option value="{{ $section -> id }}">{{ $section -> name }}</option> @endforeach</select>
                        <select id="product" class="d-none" name="product">@foreach ($products as $product) <option value="{{ $product -> id }}">{{ $product -> name }} </option>@endforeach</select>
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="number" class="mr-sm-2">{{ trans('invoices/invoices.number') }} :</label>
                                <input type="text" id="number" name="number" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="total" class="mr-sm-2">{{ trans('invoices/invoices.total') }} :</label>
                                <input type="number" id="total" name="total" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <label for="payment_status" class="mr-sm-2">{{ trans('invoices/invoices.status') }} :</label>
                                <div class="box">
                                    <select id="payment_status" class="fancyselect" name="payment_status">
                                        <option selected disabled value="">{{ trans('invoices/invoices.choose') }}</option>
                                        <option value="1">مدفوعة</option>
                                        <option value="3">مدفوعة جزئيا</option>
                                    </select>
                                </div>
                                <label id="payment_status_error" class="error ui red pointing label transition d-none" for="payment_status"></label>
                            </div>
                            <div class="col mt-2 mb-2">
                                <label for="payment_date" class="mr-sm-2">{{ trans('invoices/invoices.payment_date') }} :</label>
                                <input type="text" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" class="form-control date-picker-default" >
                                <label id="payment_date_error" class="error ui red pointing label transition d-none" for="payment_date"></label>
                            </div>
                        </div>

                        <div class="form-group mt-2 mb-2">
                            <label for="note">{{ trans('invoices/invoices.note') }}:</label>
                            <textarea id="note" name="note" class="form-control" rows="5" style="resize:none;"></textarea>
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
<!-- Payment Modal -->

<!-- Archive Modal -->
@if (Auth::user()->can('أرشفة فاتورة') or Auth::user()->can('Archive Invoice'))
    <div class="modal fade archiveModal" id="archiveModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.archive_invoice') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="archiveForm" action="{{ route('archiveInvoice') }}" method="POST">
                        @csrf
                        {{ trans('invoices/invoices.archive_warning') }}
                        <div class="row">
                            <div class="col mt-2 mb-2">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="text" disabled
                                    value=""
                                    id="number"
                                    class="form-control">
                            </div>
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('invoices/invoices.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('invoices/invoices.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Archive Modal -->

<!-- Archive Selected Modal -->
@if (Auth::user()->can('أرشفة الفواتير المختارة') or Auth::user()->can('Archive Selected Invoices'))
    <div class="modal fade" id="archive_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.archive_selected') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="archive_selectedForm" action="{{ route('archiveSelectedInvoices') }}" method="POST">
                        @csrf
                        {{ trans('invoices/invoices.archive_warning') }}
                        <input id="archive_selected_id" type="hidden" value=""
                            name="archive_selected_id" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('invoices/invoices.close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ trans('invoices/invoices.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Archive Selected Modal -->
