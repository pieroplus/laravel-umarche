<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use App\Services\CartService;
use Stripe\StripeClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendThanksMail;
use App\Mail\ThanksMail;

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

    public function checkout(): RedirectResponse
    {
        /////////
        $items = Cart::where('user_id', '=', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        $user = User::findOrFail(Auth::id());
        SendThanksMail::dispatch($products, $user);
        dd('ユーザメール送信');
        /////////
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        $lineItems = [];
        foreach($products as $product) {
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');

            if ($product->pivot->quantity > $quantity) {
                return redirect()->route('user.cart.index');
            }

            // ストライプに渡す前に在庫を減らす
            foreach($products as $product){
                Stock::create([
                    'product_id' => $product->id,
                    'type' => \Constant::PRODUCT_LIST['reduce'],
                    'quantity' => $product->pivot->quantity * -1,
                ]);
            }


            $lineItem = [
                'quantity' => $product->pivot->quantity,
                'price_data' => [
                    'unit_amount' => $product->price,
                    'currency' => 'JPY',
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->information,
                    ],
                ],
            ];
            $lineItems[] = $lineItem;
        }

        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $session = $stripe->checkout->sessions->create([
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);

        $publicKey = env('STRIPE_PUBLIC_KEY');
        // dd($session->url);

        return redirect($session->url);

        // header("HTTP/1.1 303 See Other");
        // header("Location: " . $session->url);

        // return view('user.checkout', compact('session', 'publicKey'));
    }

    public function success(): RedirectResponse
    {
        Cart::where('user_id', '=', Auth::id())->delete();
        return redirect()->route('user.items.index');
    }

    public function cancel()
    {
        $user = User::findOrFail(Auth::id());

        foreach($user->products as $product){
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity
            ]);
        }

        return redirect()->route('user.cart.index');
    }
}
