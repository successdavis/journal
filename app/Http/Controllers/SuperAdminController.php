<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Publication;
use App\Models\Receipt;
use App\Models\RoleRequest;
use App\Models\SuperAdmin;
use App\Http\Requests\StoreSuperAdminRequest;
use App\Http\Requests\UpdateSuperAdminRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $total_sales = Receipt::sum('amount');
        $author = Role::where('name', 'Author')->first();
        $reviewer = Role::where('name', 'Reviewer')->first();
        $editor = Role::where('name', 'Editor')->first();
        $totalUsers = User::all()->count();
        $totalArticles = Publication::all()->count();

        $total_authors = DB::table('model_has_roles')
            ->where('role_id', $author->id)->count();

        $total_reviewers = DB::table('model_has_roles')
            ->where('role_id', $reviewer->id)->count();

        $total_editors = DB::table('model_has_roles')
            ->where('role_id', $editor->id)->count();

        $publishedArticles = Publication::where('status', 'published')->count();
        $articlesUnderReview = Publication::where('status', 'under_review')->count();
        $articlesAcceptedForPublication = Publication::where('status', 'accepted')->count();
        $articlesRejected = Publication::where('status', 'rejected')->count();
        $articlesWithDrawn = Publication::where('status', 'withdrwan_by_author')->count();
        $articlesResubmittedElsewhere = Publication::where('status', 'resubmit_elsewhere')->count();

        return response()->json([
            ['title' => 'total_sales', 'value' => $total_sales],
            ['title' => 'total_authors', 'value' => $total_authors],
            ['title' => 'total_reviewers', 'value' => $total_reviewers],
            ['title' => 'total_editors', 'value' => $total_editors],
            ['title' => 'published_articles', 'value' => $publishedArticles],
            ['title' => 'under_review', 'value' => $articlesUnderReview],
            ['title' => 'accepted_articles', 'value' => $articlesAcceptedForPublication],
            ['title' => 'rejected_articles', 'value' => $articlesRejected],
            ['title' => 'articles_withdrawn_by_authors', 'value' => $articlesWithDrawn],
            ['title' => 'articles_resubmitted_elsewhere', 'value' => $articlesResubmittedElsewhere],
            ['title' => 'total_articles', 'value' => $totalArticles],
            ['title' => 'total_users', 'value' => $totalUsers],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    public function viewStats($stats_title)
    {
        switch ($stats_title){
            case 'total_sales':
                $data = Receipt::with('user', 'publication.author')
                    ->where('status', 'successful')
                    ->get();
                    break;
            case 'total_authors':
                $data = Role::with('users')->where('name', 'Author')->get();
                    break;
            case 'total_reviewers':
                $data = Role::with('users')->where('name', 'Reviewer')->get();
                    break;
            case 'total_editors':
                $data = Role::with('users')->where('name', 'Editor')->get();
                    break;
            case 'published_articles':
                $data = Publication::with('author')->where('status', 'published', null)->get();
                    break;
            case 'under_review':
                $data = Publication::with('author')->where('status', 'under_review')->get();
                    break;
            case 'accepted_articles':
                $data = Publication::with('author')->where('status', 'accepted')->get();
                    break;
            case 'rejected_articles':
                $data = Publication::with('author')->where('status', 'rejected')->get();
                    break;
            case 'articles_withdrawn_by_authors':
                $data = Publication::with('author')->where('status', 'articles_withdrawn_by_author')->get();
                    break;
            case 'total_articles':
                $data = Publication::with('author')->get();
                    break;
            case 'total_users':
                $data = User::all();
                    break;
            default:
                abort(404);
        }
        return inertia::render('Super_Admin/StatDetails', [
            'data' => $data,
            'page_title' => $stats_title,
        ]);

    }

    public function roleRequests()
    {
        return inertia::render('Super_Admin/RoleRequests', [
            'roleRequests' => RoleRequest::with('user', 'role')->get(),
        ]);
    }

    public function responseToRoleRequest(Request $request, $role_request_id)
    {
        $request->validate([
            'option' => 'required|in:Accepted,Rejected',
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);


        DB::transaction(function () use ($request, &$role_request_id) {
            $roleRequest = RoleRequest::findOrFail($role_request_id);
            $roleRequest->status = $request->option;
            $roleRequest->save();
            $defaultRole = Role::where('name', 'Reader')->get();
            $roleToUpdate = DB::table('model_has_role')
                ->where('role_id', $request->role_id)
            ->where('model_id', $request->user_id);

            if ($request->option === 'Accepted') {

                $roleToUpdate->model_id = $request->user_id;
                $roleToUpdate->role_id = $request->role_id;
            } else {
                $roleToUpdate->model_id = $request->user_id;
                $roleToUpdate->role_id = $defaultRole->id;
            }

            Notification::create([
                'notifiable_type' => get_class($roleRequest),
                'notifiable_id' => $roleRequest->id,
                'receiver_id' => $roleRequest->user_id,
                'sender_id' => auth()->id(),
                'message' => 'Your request to be an author has been' . $request->option,
                'status' => false,
            ]);
        });


        $data = RoleRequest::with('user', 'role')->get();


        return response()->json($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuperAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuperAdminRequest $request, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $superAdmin)
    {
        //
    }
}
