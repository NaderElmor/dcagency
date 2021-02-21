<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.index', compact('sections','products'));
    }


    public function store(Request $request)
    {

        Product::create([
            'name' => $request->name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }



    public function update(Request $request)
    {
        $id = Section::where('name', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->id);

        $Products->update([
            'name' => $request->name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return back();

    }

    public function destroy(Request $request)
    {
        $Products = Product::findOrFail($request->id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
