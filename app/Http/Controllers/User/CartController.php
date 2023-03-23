<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{

public function index(): View
{
    $user = User::findOrFail(Auth::id());
    $products = $user->products;
    $totalPrice = 0;

    foreach($products as $product){
        $totalPrice += $product->price * $product->pivot->quantity;
    }

    // dd($user, $products, $totalPrice);

    return view('user.cart', [
        'products' => $products,
        'totalPrice' => $totalPrice,
    ]);
}

    public function add(Request $request): RedirectResponse
    {
        $itemInCart = Cart::where('product_id', '=', $request->product_id)
            ->where('user_id', '=', Auth::id())
            ->first();
        
        if ($itemInCart) {
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        return redirect()->route('user.cart.index');
    }

    public function delete(string $id): RedirectResponse
    {
        Cart::where('product_id', $id)
        ->where('user_id', Auth::id())
        ->delete();

        return redirect()->route('user.cart.index');
    }
}
