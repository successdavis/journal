<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index() {
        return Inertia::render('Author/Index');
    }
    public function publications(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'submissions' => $user->publications()->latest()->get()->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'status' => $article->status,
                    'date' => $article->created_at->format('Y-m-d'),
                ];
            }),
        ]);
    }

    public function getPublications()
    {
        $user = auth()->user();

        return inertia::render('Author/MyPublications', [
            'publications' => Publication::with('author')->where('author_id', $user->id)->get(),
        ]);
    }

}
