<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $articles = Author::where('author_id', $userId)->get();

        return Inertia::render('Author/MySubmissions', [
            'articles' => $articles->isNotEmpty() ? $articles : [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia::render('Author/NewManuscript', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreAuthorRequest $request)
    {
        $data = $request->validated();

        // Handle file uploads
        $mainDocumentPath = $request->file('main_document')->store('manuscripts/main', 'public');

        $figuresPaths = [];
        if ($request->hasFile('figures')) {
            foreach ($request->file('figures') as $figure) {
                $figuresPaths[] = $figure->store('manuscripts/figures', 'public');
            }
        }

        $supplementaryPaths = [];
        if ($request->hasFile('supplementary')) {
            foreach ($request->file('supplementary') as $supplementary) {
                $supplementaryPaths[] = $supplementary->store('manuscripts/supplementary', 'public');
            }
        }

        $coverLetterPath = null;
        if ($request->hasFile('cover_letter')) {
            $coverLetterPath = $request->file('cover_letter')->store('manuscripts/cover_letters', 'public');
        }

        // Save to DB
        Author::create([
            'title' => $data['title'],
            'author_id' => Auth::user()->id,
            'abstract' => $data['abstract'],
            'keywords' => $data['keywords'],
            'article_type' => $data['article_type'],
            'affiliation' => $data['affiliation'],
            'journal' => $data['journal'],
            'subject_area' => $data['subject_area'],
            'main_document' => $mainDocumentPath,
            'figures' => json_encode($figuresPaths),
            'supplementary' => json_encode($supplementaryPaths),
            'cover_letter' => $coverLetterPath,
            'ethical_approval' => $data['ethical_approval'] ?? null,
            'conflict_of_interest' => $data['conflict_of_interest'] ?? null,
            'funding_statement' => $data['funding_statement'] ?? null,
            'consent' => $data['consent'],
            'originality' => $data['originality'],
        ]);

        return response()->json(['message' => 'Manuscript submitted successfully.']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
