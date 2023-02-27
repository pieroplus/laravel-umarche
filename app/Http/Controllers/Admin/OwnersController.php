<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Owner\OwnerStoreRequest;
use App\Http\Requests\Owner\OwnerUpdateRequest;
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
        $owners = Owner::select('id', 'name', 'email', 'created_at')->paginate(3);
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
            ->with(['message' => "オーナーを登録しました。"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $owner = Owner::findOrFail($id);
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnerUpdateRequest $request, string $id): RedirectResponse
    {
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();
        return redirect()->route('admin.owners.index')
            ->with(['message' => '更新に成功しました。']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Owner::findOrFail($id)->delete();
        return redirect()->route('admin.owners.index')
            ->with(
                [
                    'status' => 'alert',
                    'message' => 'オーナー情報を削除しました。'
                ]
            );
    }

    public function expiredOwnerIndex(): View
    {
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners', compact('expiredOwners'));
    }

    public function expiredOwnerRestore(string $id): RedirectResponse
    {
        Owner::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.owners.index')
            ->with(
                [
                    'status' => 'info',
                    'message' => '期限切れのオーナーを復活させました。'
                ]);
    }
    
    public function expiredOwnerDestroy(string $id): RedirectResponse
    {
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index')
            ->with(
                [
                    'status' => 'alert',
                    'message' => '期限切れオーナーを完全に削除しました。',
                ]
            ); 
    }
}
