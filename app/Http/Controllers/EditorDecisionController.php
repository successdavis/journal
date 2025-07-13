<?php

namespace App\Http\Controllers;

use App\Models\ManuscriptReviewer;
use App\Models\Notification;
use App\Models\Publication;
use App\Models\EditorDecision;
use App\Http\Requests\StoreEditorDecisionRequest;
use App\Http\Requests\UpdateEditorDecisionRequest;
use App\Models\SubmittedReview;
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
    public function store(StoreEditorDecisionRequest $request, $review_id)
    {
        $data = $request->validated();
        $data['editor_id'] = Auth::user()->id;

        $manuscript = Publication::findOrFail($data['manuscript_id']);
        $manuscript->status = $data['decision'];
        $manuscript->save();

        $submittedReview = SubmittedReview::findOrFail($review_id);

        $decision = EditorDecision::create($data);
        Notification::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $data['reviewer_id'],
            'message' => 'The editor has made a decision on your submitted review.',
            'notifiable_type' =>  get_class($decision),
            'notifiable_id' => $decision->id,
        ]);

       $editorDecision = EditorDecision::with('editor')
                ->where('submitted_review_id', $submittedReview->id)
                ->first();

        return response()->json([
            'review' => $submittedReview,
            'editorDecision' => $editorDecision,
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
