<?php

namespace App\Http\Controllers;

use App\Models\ManuscriptReviewer;
use App\Models\Reviewer;
use App\Http\Requests\StoreReviewerRequest;
use App\Http\Requests\UpdateReviewerRequest;
use App\Models\SubmittedReview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use PHPUnit\TextUI\Output\SummaryPrinter;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $assignedReviews = User::with('reviewedManuscripts.author')->find($user->id);

        return inertia::render('Reviewer/View', [
            'assignedReviews'=> $assignedReviews
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function history()
    {
        $reviewer = Auth::user();
        $reviews = SubmittedReview::whereHas('reviewManuscript', function ($query) use ($reviewer) {
            $query->where('reviewer_id', $reviewer->id);
        })->with('reviewManuscript.manuscript')->latest()->get();

        return inertia('Reviewer/History', [
            'reviews' => $reviews,
        ]);



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reviewer $reviewer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reviewer $reviewer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewerRequest $request, Reviewer $reviewer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviewer $reviewer)
    {
        //
    }
}
