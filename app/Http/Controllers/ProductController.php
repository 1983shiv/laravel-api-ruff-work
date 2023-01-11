<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     return Product::create([
    //         'name' => 'Product 1',
    //         'slug' => 'product-1',
    //         'description' => 'for product 1',
    //         'quantity' => 1,
    //         'price' => 113.22
    //     ]);
    // }

    public function store(Request $request)
    {
        
        // below code will pass every input that is fillable on product model
        // return Product::create($request->all());

        //Validate the fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ]);

        //Create a new product
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->slug = $validatedData['slug'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];

        //save the product
        $product->save();

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return redirect()->back()->with('error', 'Product not found');
        }

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $product->name = $request->has('name') ? $request->input('name') : $product->name;
        $product->slug = $request->has('slug') ? $request->input('slug') : $product->slug;
        $product->quantity = $request->has('quantity') ? $request->input('quantity') : $product->quantity;
        $product->description = $request->has('description') ? $request->input('description') : $product->description;
        $product->price = $request->has('price') ? $request->input('price') : $product->price;

        $product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product === null) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully with id '. $id,
        ], 200);
    }
}
