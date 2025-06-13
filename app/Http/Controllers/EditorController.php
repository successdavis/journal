<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Editor;
use App\Http\Requests\StoreEditorRequest;
use App\Http\Requests\UpdateEditorRequest;
use App\Models\ManuscriptReviewer;
use App\Models\SubmittedReview;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia::render('Editor/AllSubmissions', [
            'manuscripts' => Author::with('author')->get()
        ]);
    }

    public function viewReviews()
    {
        $reviews = SubmittedReview::whereHas('reviewManuscript')
            ->with([
                'reviewManuscript.reviewer', // Load reviewer info
                'reviewManuscript.manuscript'
            ])
            ->latest()
            ->get();

        return inertia::render('Editor/AllReviews', [
            'reviews' => $reviews,
        ]);
    }

    public function viewReviewsSection($item_id)
    {
        $reviews = SubmittedReview::whereHas('reviewManuscript', function ($query) use ($item_id) {
            $query->where('manuscript_id', $item_id);
        })
            ->with([
                'reviewManuscript.reviewer', // Load reviewer info
                'reviewManuscript.manuscript'
            ])
            ->latest()
            ->get();

        return response()->json($reviews);

    }

    public function viewManuscript($item_id)
    {
//        dd($item_id);
        $item = Author::with('author')->findOrFail($item_id);
        $item->figures = json_decode($item->figures);
        $item->supplementary = json_decode($item->supplementary);
        $existingReviewers = ManuscriptReviewer::with('reviewer')
            ->where('manuscript_id', $item_id)
            ->get();
        return inertia::render('Editor/View', [
            'item' => $item,
            'existingReviewers' => $existingReviewers,
            'reviewers' => User::where('role', 'reviewer')->get()
        ]);
    }

    public function trackReviewManuscript($item_id)
    {
        $item = Author::with('author')->findOrFail($item_id);
        $item->figures = json_decode($item->figures);
        $item->supplementary = json_decode($item->supplementary);
        $existingReviewers = ManuscriptReviewer::with('reviewer')
            ->where('manuscript_id', $item_id)
            ->get();
        return inertia::render('Editor/AssignAndTrackReviewers', [
            'item' => $item,
            'existingReviewers' => $existingReviewers,
            'reviewers' => User::where('role', 'reviewer')->get()
        ]);
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
    public function store(StoreEditorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Editor $editor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Editor $editor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEditorRequest $request, Editor $editor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Editor $editor)
    {
        //
    }
}
