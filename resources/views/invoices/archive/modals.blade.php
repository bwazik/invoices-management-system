<!-- Unarchive Modal -->
@if (Auth::user()->can('إلغاء أرشفة فاتورة') or Auth::user()->can('Unarchive Invoice'))
    <div class="modal fade unarchiveModal" id="unarchiveModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.unarchive_invoice') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="unarchiveForm" action="{{ route('unarchiveInvoice') }}" method="POST">
                        @csrf
                        {{ trans('invoices/invoices.unarchive_warning') }}
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
                        <button type="submit" class="btn btn-success">{{ trans('invoices/invoices.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<!-- Unarchive Modal -->

<!-- Unarchive Selected Modal -->
@if (Auth::user()->can('إالغاء أرشفة الفواتير المختارة') or Auth::user()->can('Unarchive Invoice'))
    <div class="modal fade" id="unarchive_selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ trans('invoices/invoices.unarchive_selected') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="unarchive_selectedForm" action="{{ route('unarchiveSelectedInvoices') }}" method="POST">
                        @csrf
                        {{ trans('invoices/invoices.unarchive_warning') }}
                        <input id="unarchive_selected_id" type="hidden" value=""
                            name="unarchive_selected_id" class="form-control">
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
<!-- Unarchive Selected Modal -->

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
                    <form id="deleteForm" action="{{ route('deleteInvoiceArchived') }}" method="POST">
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
