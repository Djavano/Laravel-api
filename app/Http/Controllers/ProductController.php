<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // retorna todos os produtos
        return Product::all();


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);
        $product = Product::create($validatedData);
        return response()->json($product, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::findOrfail($id);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
        //
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|required|string'
        ]);

        $product = Product::findOrfail($id);
        $product->update($validatedData);
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Product::findOrFail($id)->delete();
        return response(null, 204);
    }
}
