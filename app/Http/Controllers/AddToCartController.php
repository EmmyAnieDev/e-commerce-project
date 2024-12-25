<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddToCartController extends Controller
{
    public $cart = [];  // Stores cart items from session

    public function __construct()
    {
        $this->cart = Session::get('cart', []);  // Initialize cart from session or empty array
    }

    public function index()
    {
        $products = Session::get('cart', []);

        return view('pages.cart', compact('products'));
    }

    public function store(Request $request, string $id)
    {
        $product = Product::findorFail($id);

        // Add product to cart array using its id as the key.
        $this->cart[$product->id] = [
            'id' => $product->id,
            'image' => $product->image,
            'name' => $product->name,
            'price' => $product->price,
            'color' => $request->color,
            'qty' => $request->qty
        ];

        // Update cart items in session storage
        Session::put('cart', $this->cart);


        return response([
            'status' => 'ok',
            'message' => 'Product added to cart successfully!',
            'cart_count' => count($this->cart)
        ]);
    }
}