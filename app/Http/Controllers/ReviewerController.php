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
use Spatie\Permission\Models\Role;
use function PHPUnit\Framework\assertInfinite;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $assignedReviews = ManuscriptReviewer::with('manuscript.author')
            ->where('reviewer_id', $user->id)
            ->get();

        return inertia::render('Reviewer/View', [
            'assignedReviews'=> $assignedReviews
        ]);
    }

    public function getReviewRequest($manuscript_id)
    {
        $user = Auth::user();
        $assignedReview = ManuscriptReviewer::where('reviewer_id', $user->id)
            ->where('manuscript_id', $manuscript_id)
            ->first();

        return response()->json($assignedReview);
    }

    public function getReviewers($publication_id)
    {
        $assignedReviewers = ManuscriptReviewer::with('user')
            ->where('manuscript_id', $publication_id)
            ->get();

        $reviewers =  Role::with('users')
            ->where('name', 'Reviewer')->first();

        return response()->json([
            'reviewers' => $reviewers,
            'assignedReviewers' => $assignedReviewers
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
        $reviews = SubmittedReview::whereHas('reviewManuscript',
            function ($query) use ($reviewer) {
            $query->where('reviewer_id', $reviewer->id);
        })->with('reviewManuscript.manuscript')->latest()->get();

        return inertia::render('Reviewer/History', [
            'reviews' => $reviews?: null,
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
