<?php

namespace App\Repositories\Invoices;

use App\Interfaces\Invoices\InvoiceDetailsRepositoryInterface;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class InvoiceDetailsRepository implements InvoiceDetailsRepositoryInterface
{
    public function getInvoiceDetails($id)
    {
        $invoice = Invoice::findOrFail($id);
        $details = InvoiceDetail::Where('invoice_id', $id)->get();
        $attachments = InvoiceAttachment::Where('invoice_id', $id)->get();

        return view('invoices.details', compact('invoice', 'details', 'attachments'));
    }

    public function show($number, $file)
    {
        return response()->file(public_path('attachments/invoices/'.$number.'/'.$file));
    }

    public function download($number, $file)
    {
        return response()->download(public_path('attachments/invoices/'.$number.'/'.$file));
    }

    public function delete($id, $number, $file)
    {
        Storage::disk('attachments')->delete('attachments/invoices/'.$number.'/'.$file);

        InvoiceAttachment::where('id', $id)->where('file', $file)->delete();

        toastr()->success(trans('invoices/details.deleted'));

        return back();
    }

    public function addAttachment($request, $invoice_id)
    {
        if ($request -> hasFile('attachments')) {

            $invoice = Invoice::findOrFail($invoice_id);
            $number = $invoice -> number;

            $count = InvoiceAttachment::where('invoice_id', $invoice_id)->count();

            if($count < 4 )
            {
                foreach ($request -> attachments as $attachment) {
                    $name = $attachment -> getClientOriginalName();
                    $attachment -> storeAs('attachments/invoices/'.$number, $attachment -> getClientOriginalName(), 'attachments');

                    InvoiceAttachment::create([
                        'number' => $number,
                        'file' => $name,
                        'invoice_id' => $invoice_id,
                        'user_id' => (Auth::user() -> id),
                    ]);
                }

                toastr()->success(trans('invoices/details.added'));

                return back();
            }
            else
            {
                toastr()->error(trans('invoices/details.error'));

                return back();
            }

        }
        else
        {
            toastr()->error('??');

            return back();
        }
    }

    public function deleteAllAttachments($request, $invoice_id)
    {
        $attchments = InvoiceAttachment::select('id')->get();
        InvoiceAttachment::whereIn('id', $attchments)->delete();

        $file = new Filesystem;
        $invoice = Invoice::findOrFail($invoice_id);
        $number = $invoice -> number;
        $file->cleanDirectory(Storage::disk('attachments')->path('attachments/invoices/'.$number));

        toastr()->success(trans('invoices/details.deleted_all'));
        return back();
    }
}
