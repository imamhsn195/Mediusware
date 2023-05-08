<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // return $request->all();
        // Validation of Product
        $request->validate([
            'title' => "required",
            'sku' => "required|unique:products",
            'description' => "required",
            "product_variant.*.value" => "required"
        ],
            $messages = [
                "product_variant.*.value.required" => "Variant value is required."
            ]
        );
        // try {
        //     B::transaction(function()use($request)
        //     {
                // Store Product
                $product = new Product();
                $product->title = $request->title;
                $product->sku = $request->sku;
                $product->description = $request->description;
                $product->save();
    
                // Store Product Variant
                foreach ($request->product_variant as $variants) {
                    foreach ($variants["value"] as $variant){
                        $new_variant = Variant::firstOrCreate(['title' => $variant]);
                        // Store Product_variant
                        $product_variant = new ProductVariant();
                        $product_variant->product_id = $product->id;
                        $product_variant->variant_id = $new_variant->id;
                        $product_variant->variant = $new_variant->title;
                        $product_variant->save();
                    }
                }
    
                // Store Product Variant Prices
                foreach ($request->product_preview as $product_variant_prices) {
                    $variants = Variant::get();
                    $exploded_variants = array_filter(explode("/", $product_variant_prices['variant']));
                    $product_variant_one = null;
                    $product_variant_two = null;
                    $product_variant_three = null;
                    if(count($exploded_variants)>=1){
                        $product_variant_one = $variants->where('title', $exploded_variants[0])->first()->id ?? null;
                    }
                    if(count($exploded_variants)>=2){
                        $product_variant_two = $variants->where('title', $exploded_variants[1])->first()->id ?? null;
                    }
                    if(count($exploded_variants)>=3){
                        $product_variant_three = $variants->where('title', $exploded_variants[2])->first()->id ?? null;  
                    }
    
                    $new_product_variant_prices = new ProductVariantPrice();
                    $new_product_variant_prices->product_variant_one = $product_variant_one;
                    $new_product_variant_prices->product_variant_two =  $product_variant_two;
                    $new_product_variant_prices->product_variant_three = $product_variant_three;
                    $new_product_variant_prices->product_id = $product->id;
                    $new_product_variant_prices->price = $product_variant_prices["price"];
                    $new_product_variant_prices->stock = $product_variant_prices["stock"];
                    $new_product_variant_prices->save();
                }
                return redirect()->back()->with(['success'=> "Product has been added successfully."]);
        //     });
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        // return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
