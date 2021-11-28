<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function created($id)
    {
        return view('pages.backend.content.product.createProduct')->with('id', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $dir = 'photo_product';
        $allowed = array("jpeg", "gif", "png", "jpg", "pdf");
        if (!is_dir($dir)){
            mkdir( $dir );       
        }
        $size = filesize($file);
        $input_file = $file->getClientOriginalName();
        $filename = pathinfo($input_file, PATHINFO_FILENAME);
        $md5Name = date("Y-m-d H-i-s")."_".$filename."_".md5($file->getRealPath());
        $guessExtension = $file->guessExtension();
        $data = $md5Name.".".$guessExtension;

        if($size > 5000000){
            return Redirect::route('type-product.index')->with(['status' => 'Ukuran File Terlalu Besar','type' => 'danger']);
        } else if (!in_array($guessExtension, $allowed)){
            return Redirect::route('type-product.index')->with(['status' => 'Tipe File Berkas Salah','type' => 'danger']);
        } else {
            $file->move($dir, $data);
            // dd($req->title);
            $image = $data;

            $product = new Product;
            $product->image = $image;
            $product->type_products_id = $request->type_products_id;
            $product->name = $request->name;
            $product->prize = $request->prize;
            if($request->discount == null) {
                $discount = 0;
            } else {
                $discount = $request->discount;
            }
            $product->discount = $discount;
            $product->hot_item = $request->hot_item;
            $product->description = $request->description;
            $product->detail = $request->detail;
            $product->tokopedia = $request->tokopedia;
            $product->shopee = $request->shopee;
            $product->lazada = $request->lazada;
            $product->bukalapak = $request->bukalapak;
            $product->olx = $request->olx;
            $product->blibli = $request->blibli;
            $product->jd = $request->jd;
            $product->bhinneka = $request->bhinneka;
            $product->save();
            return Redirect::route('type-product.index')
                ->with([
                    'status' => 'Berhasil menambah Type Product ',
                    'type' => 'success'
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        dd("halaman lihat");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.backend.content.product.editProduct', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $file = $request->file('image');
        if($file == null) {
            $image = null;
        } else {
            $dir = 'photo_product';
            $allowed = array("jpeg", "gif", "png", "jpg", "pdf");
            if (!is_dir($dir)){
                mkdir( $dir );       
            }
            $size = filesize($file);
            $input_file = $file->getClientOriginalName();
            $filename = pathinfo($input_file, PATHINFO_FILENAME);
            $md5Name = date("Y-m-d H-i-s")."_".$filename."_".md5($file->getRealPath());
            $guessExtension = $file->guessExtension();
            $data = $md5Name.".".$guessExtension;

            if($size > 5000000){
                return Redirect::route('type-product.index')->with(['status' => 'Ukuran File Terlalu Besar','type' => 'danger']);
            } else if (!in_array($guessExtension, $allowed)){
                return Redirect::route('type-product.index')->with(['status' => 'Tipe File Berkas Salah','type' => 'danger']);
            } else {
                $file->move($dir, $data);
                // dd($req->title);
                $image = $data;
            }
        }
        $product->type_products_id = $request->type_products_id;
        $product->name = $request->name;
        $product->prize = $request->prize;
        if($request->discount == null) {
            $discount = 0;
        } else {
            $discount = $request->discount;
        }
        if($image != null) {
            $product->image = $image;
        }
        $product->discount = $discount;
        $product->hot_item = $request->hot_item;
        $product->description = $request->description;
        $product->detail = $request->detail;
        $product->tokopedia = $request->tokopedia;
        $product->shopee = $request->shopee;
        $product->lazada = $request->lazada;
        $product->bukalapak = $request->bukalapak;
        $product->olx = $request->olx;
        $product->blibli = $request->blibli;
        $product->jd = $request->jd;
        $product->bhinneka = $request->bhinneka;
        $product->save();
        return Redirect::route('type-product.show', $request->type_products_id)
        ->with([
            'status' => 'Berhasil mengubah Product ',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function deleted($id)
    {

        $product = Product::find($id);
        $type = $product->type_products_id;
        $delete = $product->delete();
        if($delete) {
            return Redirect::route('type-product.show', $type)
            ->with([
                'status' => 'Berhasil Hapus Product',
                'type' => 'success'
            ]);
        } else {
            return Redirect::route('type-product.show', $type)
            ->with([
                'status' => 'Gagal Hapus Product',
                'type' => 'success'
            ]);
        }
    }
    public function destroy(Product $product)
    {
        $type = $product->type_products_id;
        $delete = $product->delete();
        if($delete) {
            return Redirect::route('type-product.show', $type)
            ->with([
                'status' => 'Berhasil Hapus Product',
                'type' => 'success'
            ]);
        } else {
            return Redirect::route('type-product.show', $type)
            ->with([
                'status' => 'Gagal Hapus Product',
                'type' => 'success'
            ]);
        }
    }
}
