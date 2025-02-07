<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    // Menampilkan daftar produk 
    public function index()
    {
        $products = Product::with('properties')->get();

        return response()->json($products);
    }

    // Menampilkan detail produk beserta properti dinamisnya 
    public function show($id)
    {
        $product = Product::with('properties')->findOrFail($id);

        return response()->json($product);
    }

    // Menambahkan produk baru beserta properti dinamisnya
    public function store(Request $request)
    {
        // validasi request tambah data 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|integer',
            'properties' => 'nullable|array',
            'properties.*.property_name' => 'required_with:properties|string|max:255',
            'properties.*.property_value' => 'required_with:properties|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Membuat produk baru
        $product = Product::create($request->only(['name', 'description', 'price']));

        // Jika properti dikirimkan
        if ($request->has('properties')) {
            foreach ($request->input('properties') as $prop) {
                $product->properties()->create($prop);
            }
        }

        return response()->json($product->load('properties'), 201);
    }

    // Mengedit properti dinamis suatu produk
    public function updateProperty(Request $request, $productId, $propertyId)
    {
        // validasi request saat update/edit property
        $validator = Validator::make($request->all(), [
            'property_name' => 'required|string|max:255',
            'property_value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($productId);
        $property = $product->properties()->findOrFail($propertyId);
        $property->update($request->only(['property_name', 'property_value']));

        return response()->json($property);
    }

    // Menghapus properti dinamis suatu produk
    public function destroyProperty($productId, $propertyId)
    {
        $product = Product::findOrFail($productId);
        $property = $product->properties()->findOrFail($propertyId);
        $property->delete();

        return response()->json(['message' => 'Properti produk berhasil dihapus.']);
    }

    // Update product beserta properties nya
    public function update(Request $request, $id)
    {
        // Validasi request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|integer',
            'properties' => 'nullable|array',
            'properties.*.id' => 'nullable|exists:product_properties,id',
            'properties.*.property_name' => 'required_with:properties|string|max:255',
            'properties.*.property_value' => 'required_with:properties|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'price']));

        // Proses properti-properti
        if ($request->has('properties')) {
            foreach ($request->input('properties') as $prop) {
                if (isset($prop['id'])) {
                    // Update properti yang sudah ada
                    $property = $product->properties()->find($prop['id']);
                    if ($property) {
                        $property->update([
                            'property_name' => $prop['property_name'],
                            'property_value' => $prop['property_value']
                        ]);
                    }
                } else {
                    // Tambah properti baru
                    $product->properties()->create([
                        'property_name' => $prop['property_name'],
                        'property_value' => $prop['property_value']
                    ]);
                }
            }
        }

        return response()->json($product->load('properties'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product_name = $product->name;
        $product->delete();


        if (Route::currentRouteName() == 'delete-redirect') {
            return response()->json($product_name . ' has been deleted');
        } else {
            return redirect('/');
        }
    }
}
