<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Rules\ProductStockPriceRule;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $products = Product::all();

        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => new ProductStockPriceRule(),
        ]);
//        $order = Order::create();
//        foreach (something) {
//            $order->products()->create($productData);
//        }
    }
}
