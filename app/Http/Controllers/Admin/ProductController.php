<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){
        $products = Product::get();
        return Inertia::render('Admin/Product/Index', ['products'=> $products]);
    }

    public function store(Request $request){
        $product = new Product;

        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->save();

        //check if product has image

        if($request->hasfile('product_images')){
            $productImages = $request->file('product_images');

            foreach ($productImages as $image){
            //Generate a unique name for the image using a timestamp and a string

            $uniqueName = time() . '-' . Str::random(10) . '.' .  $image->getClientOriginalExtension();
            $image->move('product_images', $uniqueName);

            //Create new product image record with the product_id and unique name

            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'product_images/' . $uniqueName,
            ]);
        }
            }

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully');

    }
}
