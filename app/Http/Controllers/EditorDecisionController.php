<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\EditorDecision;
use App\Http\Requests\StoreEditorDecisionRequest;
use App\Http\Requests\UpdateEditorDecisionRequest;
use Illuminate\Support\Facades\Auth;

class EditorDecisionController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEditorDecisionRequest $request)
    {
        $data = $request->validated();

        $data['editor_id'] = Auth::user()->id;

        $manuscript = Publication::find($data['manuscript_id']);
        $manuscript->status = $data['decision'];
        $manuscript->save();


        $decision = EditorDecision::create($data);
        return response()->json([
            'message' => 'Decision saved successfully',
            'decision' => $decision,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EditorDecision $editorDecision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditorDecision $editorDecision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEditorDecisionRequest $request, EditorDecision $editorDecision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EditorDecision $editorDecision)
    {
        //
    }
}
