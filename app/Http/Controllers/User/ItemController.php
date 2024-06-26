<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendThanksMail;
use App\Mail\TestMail;

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
    
    public function index(Request $request): View
    {
        // 同期的に送信
        // Mail::to('test@example.com')
        //     ->send(new TestMail());

        //非同期で送信
        // SendThanksMail::dispatch();
        $categories = PrimaryCategory::with('secondary')->get();
        $products = Product::availableItems()
            ->selectCategory($request->category ?? '0')
            ->searchKeyword($request->keyword)
            ->sortOrder($request->sort)
            ->paginate($request->pagination ?? 20);
        return view('user.index', [
            'products' => $products,
            'categories' => $categories,
            ]
        );
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

