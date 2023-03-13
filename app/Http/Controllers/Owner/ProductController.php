<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Owner;
use App\Models\Image;
use App\Models\PrimaryCategory;
use App\Models\Shop;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');
        $this->middleware(function ($request, $next) {
            $paramId = $request->route()->parameter('product');
            if (!is_null($paramId)) {
                $productOwnerId = Product::findOrFail($paramId)->shop->owner->id;
                if (Auth::id() !== (int)$productOwnerId) {
                    abort(403);
                }
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
public function index(): View
{
    // $products = Owner::findOrFail(Auth::id())->shop->product;
    $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id', '=', Auth::id())
        ->get();
    return view('owner.products.index', compact('ownerInfo'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $shops = Shop::where('owner_id', '=', Auth::id())
            ->select('id', 'name')
            ->get();
        
        $images = Image::where('owner_id', '=', Auth::id())
            ->select('id', 'title', 'filename')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $categories = PrimaryCategory::with('secondary')
            ->get();
        
        return view('owner.products.create',
            compact('shops', 'images', 'categories')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
