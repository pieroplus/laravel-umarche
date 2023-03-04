<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class ShopController extends Controller
{

public function __construct()
{
    $this->middleware('auth:owners');
    $this->middleware(function ($request, $next) {
        $paramId = $request->route()->parameter('shop');
        if (!is_null($paramId)) {
            $ownerId = Shop::findOrFail($paramId)->owner->id;
            if (Auth::id() !== (int)$ownerId) {
                abort(403);
            }
        }
        return $next($request);
    });
}

    public function index() :View
    {
        $ownerId = Auth::id();
        $shops = Shop::where('owner_id', '=', $ownerId)->get();
        return view('owner.shops.index', compact('shops'));
    }

public function edit(string $id): View
{
    $shop = Shop::findOrFail($id);
    // if (Auth::id() !== (int)$shop->owner->id) {
    //     abort(403);
    // }
    return view('owner.shops.edit', compact('shop'));
}

    public function update(Request $request, string $id): RedirectResponse
    {
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid()) {
            Storage::putFile('public/shops', $imageFile);
        }
        return redirect()->route('owner.shops.index');
    }
}
