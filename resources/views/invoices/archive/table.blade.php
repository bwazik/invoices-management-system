@if (Auth::user()->can('حذف الفواتير المختارة') or Auth::user()->can('Delete Selected Invoices'))
    </button><button type="button" class="button x-small ml-2" id="delete_all_btn">
        {{ trans('invoices/invoices.delete_selected') }}
    </button>
@endif

@if (Auth::user()->can('إالغاء أرشفة الفواتير المختارة') or Auth::user()->can('Unarchive Invoice'))
    <button type="button" class="button x-small ml-2" id="unarchive_all_btn">
        {{ trans('invoices/invoices.unarchive_selected') }}
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
                <th>{{ trans('invoices/invoices.number') }}</th>
                <th>{{ trans('invoices/invoices.total') }}</th>
                <th>{{ trans('invoices/invoices.status') }}</th>
                <th>{{ trans('invoices/invoices.section') }}</th>
                <th>{{ trans('invoices/invoices.product') }}</th>
                <th>{{ trans('invoices/invoices.processes') }}</th>
            </tr>
        </thead>
        @include('invoices.archive.modals')
    </table>
</div>
