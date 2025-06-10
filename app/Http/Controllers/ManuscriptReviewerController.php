<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\ManuscriptReviewer;
use App\Http\Requests\StoreManuscriptReviewerRequest;
use App\Http\Requests\UpdateManuscriptReviewerRequest;
use App\Models\User;

class ManuscriptReviewerController extends Controller
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
    public function store($reviewer_id, $item_id)
    {
        $reviewer = User::findOrFail($reviewer_id);
        $manuscript = Author::findOrFail($item_id);

        ManuscriptReviewer::create([
            'manuscript_id' => $manuscript->id,
            'reviewer_id' => $reviewer->id,
        ]);
        $existingReviewers = ManuscriptReviewer::with('reviewer')
            ->where('manuscript_id', $item_id)
            ->get();

        return response()->json($existingReviewers);


    }

    /**
     * Display the specified resource.
     */
    public function show(ManuscriptReviewer $manuscriptReviewer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManuscriptReviewer $manuscriptReviewer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManuscriptReviewerRequest $request, ManuscriptReviewer $manuscriptReviewer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($reviewer_id, $item_id)
    {
        ManuscriptReviewer::where('reviewer_id', $reviewer_id)
            ->where('manuscript_id', $item_id)
            ->delete();

        return response()->json(['message' => 'Reviewer unassigned successfully.']);

    }
}
