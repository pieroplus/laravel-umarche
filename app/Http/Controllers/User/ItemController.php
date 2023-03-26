<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('item');
            if (!is_null($id)) {
                $itemId = Product::availableItems()->where('products.id', '=', $id)->exists();
                if (!$itemId) {
                    abort(404);
                }
            }
            return $next($request); 
        });
    }
    
    public function index(): View
    {
        $products = Product::availableItems()->get();
        return view('user.index', ['products' => $products]);
    }

    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');

        if($quantity > 9){
            $quantity = 9;
        }

        return view('user.show', 
        [
            'product' => $product,
            'quantity' => $quantity
        ]);
    }
}
