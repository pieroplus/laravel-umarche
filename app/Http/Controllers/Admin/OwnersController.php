<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Owner\OwnerStoreRequest;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Owner; // Eloquent
use Illuminate\Support\Facades\DB; // QueryBuilder
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OwnersController extends Controller
{

public function __construct()
{
    $this->middleware('auth:admin');
}
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $owners = Owner::select('name', 'email', 'created_at')->get();
        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerStoreRequest $request): RedirectResponse
    {
        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.owners.index')
            ->with('message', "オーナーを登録しました。");
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
