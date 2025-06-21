<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
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

}
