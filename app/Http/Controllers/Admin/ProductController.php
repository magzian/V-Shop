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
    // Validate the request
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'brand_id' => 'required|exists:brands,id',
        'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Create the product
    $product = new Product;
    $product->title = $request->title;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->description = $request->description;
    $product->category_id = $request->category_id;
    $product->brand_id = $request->brand_id;
    $product->save();

    // Handle image upload
    if($request->hasFile('product_image')){
        $image = $request->file('product_image');
        
        // Generate a unique name for the image
        $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        
        // Create the directory if it doesn't exist
        $uploadPath = public_path('product_image');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Move the image to public/product_image folder
        $image->move($uploadPath, $uniqueName);
        
        // Create product image record
        ProductImage::create([
            'product_id' => $product->id,
            'image' => 'product_image/' . $uniqueName,
        ]);
    }

    return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
}

    

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


    /* public function deleteImage($id){
        $image = ProductImage::where('id', $id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Image deleted successfully');
    } */

    public function destroy($id){
        $product = Product::findorfail($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }
}
