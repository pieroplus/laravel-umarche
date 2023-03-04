<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

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

    // public function update(OwnerUpdateRequest $request, string $id): RedirectResponse
    // {
    //     $owner = Owner::findOrFail($id);
    //     $owner->name = $request->name;
    //     $owner->email = $request->email;
    //     $owner->password = Hash::make($request->password);
    //     $owner->save();
    //     return redirect()->route('admin.owners.index')
    //         ->with(['message' => '更新に成功しました。']);
    // }
}
