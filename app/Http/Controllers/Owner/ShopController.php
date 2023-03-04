<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use InterventionImage;
use App\Http\Requests\Shop\ShopUpdateRequest;
use App\Services\ImageService;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owners');
        $this->middleware(function ($request, $next) {
            $paramId = $request->route()->parameter('shop');
            if (!is_null($paramId)) {
                $imagesOwnerId = Shop::findOrFail($paramId)->owner->id;
                if (Auth::id() !== (int)$imagesOwnerId) {
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

public function update(ShopUpdateRequest $request, string $id): RedirectResponse
{
    $imageFile = $request->image;
    // dd($imageFile);
    $shop = Shop::findOrFail($id);
    $shop->name = $request->name;
    $shop->information = $request->information;
    $shop->is_selling = $request->is_selling;
    if(!is_null($imageFile) && $imageFile->isValid()) {
        $fileNameToStore = ImageService::upload($imageFile, 'shops');
        $shop->filename = $fileNameToStore;
    }
    $shop->save();
    return redirect()->route('owner.shops.index')
        ->with(['message' => '更新に成功しました。']);
    }
}
