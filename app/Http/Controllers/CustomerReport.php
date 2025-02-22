<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Invoice;
class CustomerReport extends Controller
{
    public function index(){

        $sections = Section::all();
        return view('reports.customers_report',compact('sections'));

    }


    public function Search_customers(Request $request){

        $section_id = $request->Section;
        $selected_section = Section::where('id',$section_id)->first();

// في حالة البحث بدون التاريخ`
        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {


            $invoices = Invoice::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report',compact('sections','selected_section'))->withDetails($invoices);


        }

        // في حالة البحث بتاريخ
        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = Section::all();


//            dd($section_name);
            return view('reports.customers_report',compact('sections','start_at','end_at','selected_section'))->withDetails($invoices);

        }



    }
}
