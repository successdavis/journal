<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::orderBy('id', 'DESC')->get();

        return inertia::render('Category/Create', [
            'categories' => $categories->isNotEmpty() ? $categories : null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriesRequest $request)
    {
        Categories::create([
            'name'        => $request->name,
            'slug'        => $request->slug,
            'description' => $request->description,
            'status'      => true,
            'user_id'     => Auth::user()->id,
            'parent_id'   => $request->parent_id,
        ]);
        $categories = Categories::orderBy('id', 'DESC')->get();

        return response()->json([
            'success' => true,
            'categories' => $categories->isNotEmpty() ? $categories : null,
            'message' => 'Category created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriesRequest $request, Categories $categories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        //
    }
}
