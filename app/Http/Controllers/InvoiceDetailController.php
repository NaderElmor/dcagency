<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;

class InvoiceDetailController extends Controller
{
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\invoices_details  $invoices_details
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $invoices = Invoice::where('id',$id)->first();
        $details  = InvoiceDetail::where('invoice_id',$id)->get();
        $attachments  = InvoiceAttachment::where('invoice_id',$id)->get();

        return view('invoices.details',compact('invoices','details','attachments'));
    }


    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\invoices_details  $invoices_details
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        $invoices = InvoiceAttachment::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($invoice_number,$file_name)
    {
        $files= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $files);
    }



    public function open_file($invoice_number,$file_name)
    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }

}
