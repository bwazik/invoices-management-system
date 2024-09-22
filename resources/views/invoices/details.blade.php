@extends('layouts.master')

@section('css')

@endsection

@section('mainTitle')
    {{ trans('invoices/details.title') }} - {{ $invoice -> number }}
@endsection

@section('pageTitle1')
    <a href="{{ route('getInvoiceDetails', $invoice -> id) }}">{{ trans('invoices/details.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('getInvoiceDetails', $invoice -> id) }}">{{ trans('invoices/details.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('invoices/details.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="tab nav-bt">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">{{ trans('invoices/details.details') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">{{ trans('invoices/details.payment') }} </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="attachments-tab" data-toggle="tab" href="#attachments" role="tab" aria-controls="attachments" aria-selected="false">{{ trans('invoices/details.attachments') }} </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="mb-0 table table-bordered table-3 text-center table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.number') }}</th>
                                                        <td>{{ $invoice-> number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.date') }}</th>
                                                        <td>{{ $invoice -> date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.due_date') }}</th>
                                                        <td>{{ $invoice -> due_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.section') }}</th>
                                                        <td>{{ $invoice -> section -> name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.product') }}</th>
                                                        <td>{{ $invoice -> product -> name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.collection_amount') }}</th>
                                                        <td>{{ number_format($invoice -> collection_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.commission_amount') }}</th>
                                                        <td>{{ number_format($invoice -> commission_amount, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.discount') }}</th>
                                                        <td>{{ number_format($invoice -> discount, 2)  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.vat') }}</th>
                                                        <td>{{ $invoice-> vat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.vat_value') }}</th>
                                                        <td>{{ number_format($invoice -> vat_value, 2)  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.total') }}</th>
                                                        <td>{{ number_format($invoice -> total, 2)  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.status') }}</th>
                                                        @if ($invoice -> status == 1)
                                                            <td>
                                                                <span class="badge badge-success">{{ trans('invoices/invoices.paid') }}</span>
                                                            </td>
                                                        @elseif($invoice -> status == 2)
                                                            <td>
                                                                <span class="badge badge-danger">{{ trans('invoices/invoices.unpaid') }}</span>
                                                            </td>
                                                        @elseif($invoice -> status == 3)
                                                            <td>
                                                                <span class="badge badge-warning">{{ trans('invoices/invoices.partial') }}</span>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ trans('invoices/invoices.note') }}</th>
                                                        <td>{{ $invoice -> note == null ? '-' : $invoice -> note }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="mb-0 table table-hover" style="text-align: center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th>{{ trans('invoices/invoices.number') }}</th>
                                                        <th>{{ trans('invoices/invoices.section') }}</th>
                                                        <th>{{ trans('invoices/invoices.product') }}</th>
                                                        <th>{{ trans('invoices/invoices.status') }}</th>
                                                        <th>{{ trans('invoices/invoices.payment_date') }}</th>
                                                        <th>{{ trans('invoices/invoices.note') }}</th>
                                                        <th>{{ trans('invoices/details.added_at') }}</th>
                                                        <th>{{ trans('invoices/details.user') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($details as $detail)
                                                        <?php $i++; ?>
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $detail -> number }}</td>
                                                            <td>{{ $detail -> section -> name }}</td>
                                                            <td>{{ $detail -> product -> name }}</td>
                                                            @if ($detail -> status == 1)
                                                            <td>
                                                                <span class="badge badge-success">{{ trans('invoices/invoices.paid') }}</span>
                                                            </td>
                                                            @elseif($detail -> status == 2)
                                                                <td>
                                                                    <span class="badge badge-danger">{{ trans('invoices/invoices.unpaid') }}</span>
                                                                </td>
                                                            @elseif($detail -> status == 3)
                                                                <td>
                                                                    <span class="badge badge-warning">{{ trans('invoices/invoices.partial') }}</span>
                                                                </td>
                                                            @endif
                                                            <td>{{ $detail -> payment_date }}</td>
                                                            <td>{{ $detail -> note }}</td>
                                                            <td>{{ $detail -> created_at -> diffForHumans() }}</td>
                                                            <td>{{ $detail -> user -> name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="attachments" role="tabpanel" aria-labelledby="attachments-tab">
                                <div class="card">
                                    <div class="card-body">
                                        @if (Auth::user()->can('إضافة مرفق') or Auth::user()->can('Add Attachment'))
                                            <form method="post" action="{{ route('addAttachment', $invoice -> id) }}"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="custom-file">
                                                    <input type="file" id="attachments" class="form-control" accept="image/jpg, image/jpeg, image/png, application/pdf" name="attachments[]" multiple required>
                                                </div>
                                                <br><br>
                                                <button type="submit" class="btn btn-primary btn-block mt-2"
                                                    name="uploadedFile">{{ trans('invoices/invoices.confirm') }}</button>
                                            </form>
                                        @endif

                                        @if (Auth::user()->can('حذف جميع المرفقات') or Auth::user()->can('Delete All Attachments'))
                                            <button type="button" class="btn btn-danger btn-block mt-2" data-toggle="modal" data-target="#delete_selected">{{ trans('invoices/details.delete_all') }}</button>
                                        @endif
                                        <br>
                                        <br>

                                        <div class="table-responsive">
                                            <table class="mb-0 table table-hover" style="text-align: center">
                                                <thead>
                                                    <tr class="text-dark">
                                                        <th>#</th>
                                                        <th scope="col">{{ trans('invoices/details.file') }}</th>
                                                        <th scope="col">{{ trans('invoices/details.user') }}</th>
                                                        <th scope="col">{{ trans('invoices/details.added_at') }}</th>
                                                        <th scope="col">{{ trans('invoices/invoices.processes') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach ($attachments as $attachment)
                                                        <?php $i++; ?>
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $attachment -> file }}</td>
                                                            <td>{{ $attachment -> user -> name }}</td>
                                                            <td>{{ $attachment -> created_at -> diffForHumans() }}</td>
                                                            <td>
                                                                @if (Auth::user()->can('عرض مرفق') or Auth::user()->can('Show Attachment'))
                                                                    <a href="{{ url('invoices/attachment/show/'. $invoice -> number . '/' . $attachment -> file) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-eye"></i></a>
                                                                @endif
                                                                @if (Auth::user()->can('تحميل مرفق') or Auth::user()->can('Download Attachment'))
                                                                    <a href="{{ url('invoices/attachment/download/'. $invoice -> number . '/' . $attachment -> file) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-download"></i></button>
                                                                @endif
                                                                @if (Auth::user()->can('حذف مرفق') or Auth::user()->can('Delete Attachment'))
                                                                    <a href="{{ url('invoices/attachment/delete/'. $attachment -> id . '/' . $invoice -> number . '/' . $attachment -> file) }}" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete All Modal -->
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
                        <form action="{{ route('deleteAllAttachments', $invoice -> id) }}" method="POST">
                            @csrf
                            {{ trans('products/products.delete_warning') }}
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
    <!-- Delete Selected Modal -->
@endsection

@section('js')
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <script type="text/javascript">
                toastr.error("{{ $error }}");
            </script>
        @endforeach
    @endif
@endsection
