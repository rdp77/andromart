<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

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
        return view('pages.backend.content.product.createTypeProduct');
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

            $typeProduct = new TypeProduct;
            $typeProduct->name = $request->name;
            $typeProduct->image = $image;
            $typeProduct->description = $request->description;
            $typeProduct->save();
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
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function show(TypeProduct $typeProduct)
    {
        $product = Product::where('type_products_id', $typeProduct->id)->latest()->get();
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
        return view('pages.backend.content.product.editTypeProduct', compact('typeProduct'));
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
        $file = $request->file('image');
        if($file == null) {
            $typeProduct->name = $request->name;
            $typeProduct->description = $request->description;
            $typeProduct->save();
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
            $typeProduct->name = $request->name;
            $typeProduct->image = $image;
            $typeProduct->description = $request->description;
            $typeProduct->save();
        }
        return Redirect::route('type-product.index')
            ->with([
                'status' => 'Berhasil mengubah Type Product ',
                'type' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeProduct  $typeProduct
     * @return \Illuminate\Http\Response
     */
    public function deleted($id)
    {

        $typeProduct = TypeProduct::find($id);
        if($delete) {
            return Redirect::route('type-product.show', $type)
            ->with([
                'status' => 'Berhasil Hapus Type Product',
                'type' => 'success'
            ]);
        } else {
            return Redirect::route('type-product.show', $type)
            ->with([
                'status' => 'Gagal Hapus Type Product',
                'type' => 'success'
            ]);
        }
    }
    public function destroy(TypeProduct $typeProduct, $id)
    {
        // $id = $typeProduct->id;
        $product = Product::where('type_products_id', $id)->get();
        foreach($product as $row) {
            $del = Product::where('id', $row->id)->first();
            $del->delete();
        }

        $typeProduct->delete();
        return Redirect()->route('product.index');
    }
}
