<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(2);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', ['categories' => $categories]);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'unit_type' => 'required|string',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'price' => 'required|numeric',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'discount_percentage' => 'required|numeric|max:100',
            'discount_amount' => 'required|numeric',
            'discount_start_date' => 'required|date',
            'discount_end_date' => 'required|date',
            'tax_percentage' => 'required|numeric|max:100',
            'tax_amount' => 'required|numeric',
        ]);

        $imagename1 = time() . '.' . $request->image1->extension();
        $request->image1->storeAs('public/images', $imagename1);
        // dd($imagename1);
        // Create a new product with the validated data
        $product = Product::create([
            'name' => $validatedData['name'],
            'unit_type' => $validatedData['unit_type'],
            'price' => $validatedData['price'],
            'discount_percentage' => $validatedData['discount_percentage'],
            'discount_amount' => $validatedData['discount_amount'],
            'discount_start_date' => $validatedData['discount_start_date'],
            'discount_end_date' => $validatedData['discount_end_date'],
            'tax_percentage' => $validatedData['tax_percentage'],
            'tax_amount' => $validatedData['tax_amount'],
            'image1' =>  $imagename1,

        ]);

        // Attach categories to the product
        $product->categories()->attach($validatedData['categories']);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product): View
    {
        $categories = Category::all();
        $pc =  Product::with('categories')->whereId($product->id)->get();
        return view('products.show', compact('product', 'categories', 'pc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();

        // Load the associated categories for the product
        $pc =  Product::with('categories')->whereId($product->id)->get();

        // $stocken =  Product::with('stockEntries')->whereId($product->id)->get();

        return view('products.edit', compact('product', 'categories', 'pc'));
    }


    public function update(Request $request, $id)
    {
        // Find the product
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'unit_type' => 'required|string',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'price' => 'required|numeric',
            'image1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount_percentage' => 'required|numeric|max:100',
            'discount_amount' => 'required|numeric',
            'discount_start_date' => 'required|date',
            'discount_end_date' => 'required|date',
            'tax_percentage' => 'required|numeric|max:100',
            'tax_amount' => 'required|numeric',
        ]);

        // Update the product data
        $imageName = time() . '_image1.' . $request->image1->extension();
        $product->update([
            'name' => $validatedData['name'],
            'unit_type' => $validatedData['unit_type'],
            'price' => $validatedData['price'],
            'discount_percentage' => $validatedData['discount_percentage'],
            'discount_amount' => $validatedData['discount_amount'],
            'discount_start_date' => $validatedData['discount_start_date'],
            'discount_end_date' => $validatedData['discount_end_date'],
            'tax_percentage' => $validatedData['tax_percentage'],
            'tax_amount' => $validatedData['tax_amount'],
            'image1' => $imageName,
        ]);

        $product->categories()->sync($validatedData['categories']);

        if ($request->hasFile('image1')) {
            $request->file('image1')->storeAs('public/images'); // Adjust storage location as needed
        }
        return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
    }


    public function destroy(Request $request, Product $product): JsonResponse
    {
        try {
            $product->delete();

            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while deleting the product'], 500);
        }
    }
}
