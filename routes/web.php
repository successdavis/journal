<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EditorDecisionController;
use App\Http\Controllers\ListPublicationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ManuscriptReviewerController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\SubmittedReviewController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('api/get-thesis-publications', [ListPublicationsController::class, 'latestThesis']);
Route::get('api/get-books-publications', [ListPublicationsController::class, 'latestBooks']);
Route::get('api/get-events-publications', [ListPublicationsController::class, 'eventListing']);
Route::get('api/publications', [ListPublicationsController::class, 'index']);

Route::get('/browse/journals-and-books', [PublicationController::class, 'allPublications']);
Route::get('/browse/journals-and-books/{publication}/show', [PublicationController::class, 'show']);

Route::get('api/author/publications', [AuthorController::class, 'publications']);


Route::get('/about-us', [AboutUsController::class, 'show']);



Route::get('/author/dashboard', function () {
    return Inertia::render('Author/Dashboard');
})->middleware(['auth', 'verified'])
    ->name('author.dashboard');

Route::get('/editor/dashboard', function () {
    return Inertia::render('Editor/Dashboard');
})->middleware(['auth', 'verified'])
    ->name('editor.dashboard');

Route::get('/reviewer/dashboard', function () {
    return Inertia::render('Reviewer/Dashboard');
})->middleware(['auth', 'verified'])
    ->name('reviewer.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/author/my-submissions', [PublicationController::class, 'index']);
    Route::get('/author/submit-new-manuscript', [PublicationController::class, 'create']);
    Route::post('/author/submit-new-manuscript', [PublicationController::class, 'store']);


    Route::get('/editor/all-submissions', [EditorController::class, 'index']);
    Route::get('/editor/{item_id}/view', [EditorController::class, 'viewManuscript']);
    Route::get('/editor/{item_id}/track-review', [EditorController::class, 'trackReviewManuscript']);
    Route::post('/editor/{reviewer_id}/assign-reviewer/{item_id}', [ManuscriptReviewerController::class, 'store']);
    Route::delete('/editor/{reviewer_id}/assign-reviewer/{item_id}', [ManuscriptReviewerController::class, 'destroy']);
    Route::get('/editor/all-reviews', [EditorController::class, 'viewReviews']);
    Route::get('/editor/all-reviews/{item_id}', [EditorController::class, 'viewReviewsSection']);
    Route::post('/editor/{review_id}/make-decision', [EditorDecisionController::class, 'store']);
    Route::get('/editor/categories/create', [CategoriesController::class, 'create']);
    Route::post('/editor/categories/create', [CategoriesController::class, 'store']);


    Route::get('/reviewer/assigned-reviews', [ReviewerController::class, 'index']);
    Route::patch('/reviewer/{reviewer_id}/accept-review/{item_id}', [ManuscriptReviewerController::class, 'update']);
    Route::patch('/reviewer/{reviewer_id}/reject-review/{item_id}', [ManuscriptReviewerController::class, 'rejectReviewRequest']);
    Route::get('/reviewer/view/{item_id}', [ManuscriptReviewerController::class, 'viewManuscript']);
    Route::get('/reviewer/{reviewer_id}/submit/{manuscript_id}', [SubmittedReviewController::class, 'create']);
    Route::post('/reviewer/{reviewer_id}/submit/{manuscript_id}', [SubmittedReviewController::class, 'store']);
    Route::get('/reviewer/review-history', [ReviewerController::class, 'history']);

});

require __DIR__ . '/auth.php';
