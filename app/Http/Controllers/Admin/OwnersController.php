<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Owner; // Eloquent
use Illuminate\Support\Facades\DB; // QueryBuilder
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

        $dateNow = Carbon::now();
        $dateParse = Carbon::parse(now());
        // echo $dateNow;
        // echo $dateParse;
        $eAll = Owner::all();
        $qGet = DB::table('owners')->select('name', 'created_at')->get();
        // $qFirst = DB::table('owners')->select('name')->first();
        // $cTest = collect(['name' => 'test']);
        // dd($eAll, $qGet, $qFirst, $cTest);
        return view('admin.owners.index', compact('eAll', 'qGet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
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
