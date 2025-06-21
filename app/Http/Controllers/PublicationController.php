<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Publication;
use App\Http\Requests\StorePublicationRequest;
use App\Models\PublicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Inertia\Inertia;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $articles = Publication::where('author_id', $userId)->get();

        return Inertia::render('Author/MySubmissions', [
            'articles' => $articles->isNotEmpty() ? $articles : [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $publicationTypes = PublicationType::all();
        $categories = Category::all();
        return inertia::render('Author/NewManuscript', [
            'publication_type' => $publicationTypes,
            'categories'          =>  $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StorePublicationRequest $request)
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
        Publication::create([
            'title' => $data['title'],
            'author_id' => Auth::user()->id,
            'abstract' => $data['abstract'],
            'keywords' => $data['keywords'],
            'publication_type_id' => $data['article_type'],
            'category_id' => $data['category'],
            'excerpt' => $data['excerpt'],
            'affiliation' => $data['affiliation'],
            'journal' => $data['journal'],
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

        return Inertia::render('ReportNotices/PublicationSuccess');
    }


    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        return Inertia::render('Publication/Show', [
            'publication'   => $publication
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Publication $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $author)
    {
        //
    }

    public function allPublications() {
        return inertia('Publication/Index');
    }
}
