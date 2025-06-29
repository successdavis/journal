<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookListingResource;
use App\Http\Resources\EventListingResource;
use App\Http\Resources\PublicationListingResource;
use App\Models\Category;
use App\Models\Event;
use App\Models\Publication;
use App\Models\PublicationType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PHPUnit\TextUI\TestRunner;

class ListPublicationsController extends Controller
{
    public function index() {
        $publications = Publication::paginate(5);

        return response()->json([
            'types' => PublicationType::all(),
            'publications' => $publications,
        ]);
    }

    public function latestThesis()
    {
        $publication = PublicationType::where('title', 'Thesis')->first();

        return response()->json([
            'categories' => $publication->categories()->pluck('name'),
            'publications' => PublicationListingResource::collection(Publication::limit(20)->get())
        ]);
    }

    public function latestBooks()
    {
        $publication = PublicationType::where('title', 'Book')->first();

        return response()->json([
            'books' => BookListingResource::collection(Publication::limit(10)->get())
        ]);
    }

    public function eventListing() {
        return response()->json([
            'events' => EventListingResource::collection(Event::latest()->limit(5)->get())
        ]);
    }

    public function fetchRelatedArticles($publication_id) {
     $article = Publication::findOrFail($publication_id);
     $keyWords = explode(',', $article->keywords);
    $publications = Publication::all();

        $results = Publication::where(function ($query) use ($keyWords) {
            foreach ($keyWords as $keyword) {
                $query->orWhere('keywords', 'like', "%$keyword%");
            }
        })->limit(5)->get();

       return response()->json($results);
    }

}
