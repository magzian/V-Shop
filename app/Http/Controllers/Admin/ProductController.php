<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category', 'brand', 'product_images')->get();
        /* dd($products); */

        $brands = Brand::get();
        $categories = Category::get();



        return Inertia::render('Admin/Product/Index', [
        'products'=> $products, 
        'brands'=> $brands, 
        'categories'=> $categories]);
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

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully');

    }

    /* public function update(Request $request, $id){
        $product = Product::findorfail($id);

        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        //Check if product images were uploaded

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

        $product->update();
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
        
    } */

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $product->update([
        'title' => $request->title,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'description' => $request->description,
        'category_id' => $request->category_id,
        'brand_id' => $request->brand_id,
    ]);

    // Handle product images
    if ($request->hasfile('product_images')) {
        foreach ($request->file('product_images') as $image) {
            $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move('product_images', $uniqueName);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'product_images/' . $uniqueName,
            ]);
        }
    }

    return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
}


    public function deleteImage($id){
        $image = ProductImage::where('id', $id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Image deleted successfully');
    }

    public function destroy($id){
        $product = Product::findorfail($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }
}
