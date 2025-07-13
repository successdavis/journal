<?php

namespace App\Http\Controllers;

use App\Models\EditorDecision;
use App\Models\ManuscriptReviewer;
use App\Models\Reviewer;
use App\Models\SubmittedReview;
use App\Http\Requests\StoreSubmittedReviewRequest;
use App\Http\Requests\UpdateSubmittedReviewRequest;
use Inertia\Inertia;
use function Laravel\Prompts\form;

class SubmittedReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($review_id)
    {
        $submittedReview = SubmittedReview::findOrFail($review_id)
        ->whereHas('manuscript')
            ->with([
                'manuscript.user', // Load reviewer info
                'manuscript.manuscript.author'
            ])->first();

        $editorDecision = EditorDecision::with('editor')
            ->where('submitted_review_id', $submittedReview->id)
            ->first();

        return inertia::render('Editor/ViewReview', [
            'review' => $submittedReview,
            'editorDecision' => $editorDecision,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($reviewer_id, $manuscript_id)
    {
        $SubmittedReview = ManuscriptReviewer::where('reviewer_id', $reviewer_id)
            ->where('manuscript_id', $manuscript_id)->first();

        return inertia::render('Reviewer/SubmitReview', [
            'submittingReviewDetails'=> $SubmittedReview
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */

        public function store(StoreSubmittedReviewRequest $request)
    {

        $existingReviews = SubmittedReview::where('review_manuscript_id', $request->review_manuscript_id)->count();
        $round = $existingReviews + 1;

        $data = $request->validated();
        $data['round'] = $round;

//         Handle file uploads
        if ($request->hasFile('annotated_manuscript')) {
            $data['annotated_manuscript'] = $request->file('annotated_manuscript')->store('reviews/annotated', 'public');
        }

        if ($request->hasFile('supplementary_feedback')) {
            $data['supplementary_feedback'] = $request->file('supplementary_feedback')->store('reviews/supplementary', 'public');
        }

        SubmittedReview::create($data);

        return response()->json(['message' => 'Review submitted successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubmittedReview $submittedReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubmittedReview $submittedReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmittedReviewRequest $request, SubmittedReview $submittedReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubmittedReview $submittedReview)
    {
        //
    }
}
