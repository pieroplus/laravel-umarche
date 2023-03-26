<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;
use App\Models\Product;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owners');
        $this->middleware(function ($request, $next) {
            $paramId = $request->route()->parameter('image');
            if (!is_null($paramId)) {
                $ownerId = Image::findOrFail($paramId)->owner->id;
                if (Auth::id() !== (int)$ownerId) {
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
        $images = Image::where('owner_id', '=', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        return view('owner.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request): RedirectResponse
    {
        $imageFiles = $request->file('files');
        if (!is_null($imageFiles)) {
            foreach($imageFiles as $imageFile) {
                $fileNameToStore = ImageService::upload($imageFile, 'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore,
                ]);
            }
        }
        return redirect()->route('owner.images.index')
            ->with([
                'message' => '画像を登録しました',
                'status' => 'info',
            ]);

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $image = Image::findOrFail($id);
        return view('owner.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();
        return redirect()->route('owner.images.index')
            ->with([
                'message' => 'タイトルを更新しました。',
                'status' => 'info',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $image = Image::findOrFail($id);

        $imageInProducts = Product::where('image1', $image->id)
            ->orWhere('image2', $image->id)
            ->orWhere('image3', $image->id)
            ->orWhere('image4', $image->id)
            ->get();

        if($imageInProducts){
            $imageInProducts->each(function($product) use($image){
                if($product->image1 === $image->id){
                    $product->image1 = null;
                    $product->save();
                }
                if($product->image2 === $image->id){
                    $product->image2 = null;
                    $product->save();
                }
                if($product->image3 === $image->id){
                    $product->image3 = null;
                    $product->save();
                }
                if($product->image4 === $image->id){
                    $product->image4 = null;
                    $product->save();
                }
            });
        }

        $filePath = 'public/products/' . $image->filename;

        if(Storage::exists($filePath)){
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete(); 

        return redirect()
        ->route('owner.images.index')
        ->with(['message' => '画像を削除しました。',
        'status' => 'alert']);
    }
}
