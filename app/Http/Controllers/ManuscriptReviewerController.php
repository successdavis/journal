<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\ManuscriptReviewer;
use App\Http\Requests\StoreManuscriptReviewerRequest;
use App\Http\Requests\UpdateManuscriptReviewerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        $manuscript = Publication::findOrFail($item_id);

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
    public function update($reviewer_id, $item_id)
    {

        $manuscriptToAccept = ManuscriptReviewer::where('reviewer_id', $reviewer_id)
            ->where('manuscript_id', $item_id)->first();

        $manuscriptToAccept->request_status = 'accepted';
        $manuscriptToAccept->status = 'in_progress';
        $manuscriptToAccept->save();

        $assignedReviews = User::with('reviewedManuscripts.author')->find($reviewer_id);


//       ViewManuscript as Reviewer
        $assignedReviewerDetails = User::with(['reviewedManuscripts' => function ($query) use ($item_id) {
            $query->where('authors.id', $item_id) // authors = manuscripts
            ->with('author'); // load the author of the manuscript
        }])->find($reviewer_id);

        $assignedReviewerDetails->reviewedManuscripts[0]
            ->figures = json_decode($assignedReviewerDetails->reviewedManuscripts[0]
            ->figures);

        $assignedReviewerDetails->reviewedManuscripts[0]
            ->supplementary = json_decode($assignedReviewerDetails->reviewedManuscripts[0]
            ->supplementary);
        return response()->json([$assignedReviews, $assignedReviewerDetails]);
    }

    public function rejectReviewRequest($reviewer_id, $item_id)
    {
//ViewManuscript as Editor
        $manuscriptToReject = ManuscriptReviewer::where('reviewer_id', $reviewer_id)
            ->where('manuscript_id', $item_id)->first();
        $manuscriptToReject->request_status = 'rejected';
        $manuscriptToReject->status = 'declined';
        $manuscriptToReject->save();

        $assignedReviews = User::with('reviewedManuscripts.author')->find($reviewer_id);
//ViewManuscript as Reviewer
        $assignedReviewerDetails = User::with(['reviewedManuscripts' => function ($query) use ($item_id) {
            $query->where('authors.id', $item_id) // authors = manuscripts
            ->with('author'); // load the author of the manuscript
        }])->find($reviewer_id);

        $assignedReviewerDetails->reviewedManuscripts[0]
            ->figures = json_decode($assignedReviewerDetails->reviewedManuscripts[0]
            ->figures);

        $assignedReviewerDetails->reviewedManuscripts[0]
            ->supplementary = json_decode($assignedReviewerDetails->reviewedManuscripts[0]
            ->supplementary);
        return response()->json([$assignedReviews, $assignedReviewerDetails]);
    }

    public function viewManuscript($item_id)
    {

        $user_id = Auth::user()->id;
        $assignedReviewerDetails = User::with(['reviewedManuscripts' => function ($query) use ($item_id) {
            $query->where('authors.id', $item_id) // authors = manuscripts
            ->with('author'); // load the author of the manuscript
        }])->find($user_id);

        $assignedReviewerDetails->reviewedManuscripts[0]
            ->figures = json_decode($assignedReviewerDetails->reviewedManuscripts[0]
            ->figures);

        $assignedReviewerDetails->reviewedManuscripts[0]
            ->supplementary = json_decode($assignedReviewerDetails->reviewedManuscripts[0]
            ->supplementary);

        return inertia::render('Reviewer/ViewManuscript', [
            'assignedReview' => $assignedReviewerDetails,
        ]);
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
