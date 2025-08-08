<?php

namespace App\Http\Controllers;

use App\Models\Manuscript;
use App\Models\ManuscriptReviewer;
use App\Models\Notification;
use App\Models\Publication;
use App\Models\EditorDecision;
use App\Http\Requests\StoreEditorDecisionRequest;
use App\Http\Requests\UpdateEditorDecisionRequest;
use App\Models\SubmittedReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function store(StoreEditorDecisionRequest $request, SubmittedReview $review)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['editor_id'] = Auth::user()->id;

            $manuscript = Manuscript::findOrFail($data['manuscript_id']);
            $manuscript->status = $data['decision'];
            $manuscript->save();

            $submittedReview = SubmittedReview::with('reviewManuscript.manuscript.author')
                ->where('id', $review->id)
                ->first();
            if (!$submittedReview) {
                throw new \Exception('Submitted review not found.');
            }
            $decision = EditorDecision::create($data);
            if (strtolower($data['decision']) === 'accept') {
              $this->publishManuscript($manuscript, $submittedReview);
            }
            Notification::create([
                'sender_id'       => Auth::user()->id,
                'receiver_id'     => $data['reviewer_id'],
                'message'         => 'The editor has made a decision on your submitted review.',
                'notifiable_type' => get_class($decision),
                'notifiable_id'   => $decision->id,
            ]);
            DB::commit();

            $editorDecision = EditorDecision::with('editor')
                ->where('submitted_review_id', $submittedReview->id)
                ->first();

            return response()->json([
                'review'          => $submittedReview,
                'editorDecision'  => $editorDecision,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    protected function publishManuscript($manuscript, $review)
    {
        Publication::create([
            'manuscript_id' => $manuscript->id,
            'review_id' => $review->id,
            'reviewer_id' => $review->reviewManuscript['reviewer_id'],
            'editor_id' => Auth::user()->id,
            'author_id' => $manuscript->author['id'],
            'title' => $review->review_title,
            'abstract' => $review->reviewed_abstract,
            'keywords' => $manuscript->keywords,
            'journal' => $manuscript->journal,

            'affiliation' => $manuscript->affiliation,
            'excerpt' => \Str::limit($review->reviewed_abstract, 250),

            'final_document' => $review->annotated_manuscript,
            'supplementary_feedback' => $review->supplementary_feedback,

            'figures' => json_encode($manuscript->figures),
            'supplementary_files' => json_encode($manuscript->supplementary),

            'publication_type_id' => $manuscript->publication_type_id,
            'amount' => $manuscript->amount,
            'premium' => $manuscript->premium,
            'category_id' => $manuscript->category_id,

            'slug' => \Str::slug($review->review_title),
            'published_at' => now(),
        ]);


    }

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
