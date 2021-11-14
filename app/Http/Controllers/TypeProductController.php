<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class TypeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeProduct = TypeProduct::orderBy('id', 'asc')->get();
        return view('pages.backend.content.product.indexTypeProduct')->with('typeProduct', $typeProduct);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function show(TypeProduct $typeProduct)
    {
        $product = Product::where('type_products_id', $typeProduct->id)->get();
        return view('pages.backend.content.product.indexProduct')->with('product', $product)->with('id', $typeProduct->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeProduct $typeProduct)
    {
        dd($typeProduct);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeProduct $typeProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeProduct $typeProduct)
    {
        $id = $typeProduct->id;
        $product = Product::where('type_products_id', $id)->get();
        foreach($product as $row) {
            $del = Product::where('id', $row->id)->first();
            $del->delete();
        }

        $typeProduct->delete();
        return Redirect()->route('product.index');
    }
}
