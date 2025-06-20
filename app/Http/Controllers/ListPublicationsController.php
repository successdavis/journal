<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicationListingResource;
use App\Models\Category;
use App\Models\Publication;
use App\Models\PublicationType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListPublicationsController extends Controller
{
    public function latestThesis()
    {
        $publication = PublicationType::where('title', 'Thesis')->first();

        return response()->json([
            'categories' => $publication->categories()->pluck('name'),
            'publications' => PublicationListingResource::collection(Publication::limit(20)->get())
        ]);
    }

}
