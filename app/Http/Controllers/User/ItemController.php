<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        return view('user.index', ['products' => $products]);
    }
}
