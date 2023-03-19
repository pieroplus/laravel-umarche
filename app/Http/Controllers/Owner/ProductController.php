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
use App\Models\Stock;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View as FacadesView;

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
    // dd($ownerInfo);
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
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'price' => 'required|integer',
            'sort_order' => 'nullable|integer',
            'quantity' => 'required|integer',
            'shop_id' => 'required|exists:shops,id',
            'category' => 'required|exists:secondary_categories,id',
            'image1' => 'nullable|exists:images,id',
            'image2' => 'nullable|exists:images,id',
            'image3' => 'nullable|exists:images,id',
            'image4' => 'nullable|exists:images,id',
            'is_selling' => 'required'
        ]);

        try{
            DB::transaction(function () use($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity
                ]);
            }, 2);
        }catch(\Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()->route('owner.products.index')
            ->with([
                'message' => '商品登録しました。',
                'status' => 'info'
            ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
            ->sum('quantity');

        $shops = Shop::where('owner_id', Auth::id())
            ->select('id', 'name')
            ->get();

        $images = Image::where('owner_id', Auth::id())
            ->select('id', 'title', 'filename')
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = PrimaryCategory::with('secondary')
            ->get();

        return view('owner.products.edit',
            compact('product', 'quantity', 'shops', 
            'images', 'categories'));
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
