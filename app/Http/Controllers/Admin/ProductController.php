<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();
        return view('products', ['products' => $products]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Store the uploaded image in the 'products' folder within 'public/storage'
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            return redirect()->back()->with('error', 'Image upload failed.');
        }

        // Create the product
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('products')->with('success', 'Product created successfully!');
    }


    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'image' => 'required',
        ]);

        // Check if an image file is present
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Get the original file name
            $fileName = time() . '_' . $file->getClientOriginalName(); // Adding a timestamp to avoid filename conflicts

            // Set the destination path
            $destinationPath = public_path('images');

            // Move the file to the specified directory
            $file->move($destinationPath, $fileName);
        } 


        // Create the product
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => 'images/' . $fileName, // Store the relative path to the image
        ]);

        return redirect()->route('products')->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        // Delete the product image from storage
        Storage::disk('public')->delete($product->image);

        // Delete the product from the database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
