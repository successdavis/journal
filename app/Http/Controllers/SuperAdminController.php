<?php

namespace App\Http\Controllers;

use App\Models\Manuscript;
use App\Models\Notification;
use App\Models\Publication;
use App\Models\Receipt;
use App\Models\RoleRequest;
use App\Models\SuperAdmin;
use App\Http\Requests\StoreSuperAdminRequest;
use App\Http\Requests\UpdateSuperAdminRequest;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
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
        $totalArticles = Manuscript::all()->count();

        $total_authors = DB::table('model_has_roles')
            ->where('role_id', $author->id)->count();

        $total_reviewers = DB::table('model_has_roles')
            ->where('role_id', $reviewer->id)->count();

        $total_editors = DB::table('model_has_roles')
            ->where('role_id', $editor->id)->count();

        $publishedArticles = Publication::all()->count();
        $articlesUnderReview = Manuscript::all()->count();
        $articlesAcceptedForPublication = Manuscript::where('status', 'accepted')->count();
        $articlesRejected = Manuscript::where('status', 'rejected')->count();
        $articlesWithDrawn = Manuscript::where('status', 'withdrwan_by_author')->count();
        $articlesResubmittedElsewhere = Manuscript::where('status', 'resubmit_elsewhere')->count();

        return response()->json([
            ['title' => 'total_sales', 'value' => $total_sales],
//            ['title' => 'total_reviewers', 'value' => $total_reviewers],
//            ['title' => 'total_editors', 'value' => $total_editors],
            ['title' => 'published_articles', 'value' => $publishedArticles],
            ['title' => 'pending_publication', 'value' => $articlesUnderReview],
//            ['title' => 'accepted_articles', 'value' => $articlesAcceptedForPublication],
//            ['title' => 'rejected_articles', 'value' => $articlesRejected],
//            ['title' => 'articles_withdrawn_by_authors', 'value' => $articlesWithDrawn],
//            ['title' => 'articles_resubmitted_elsewhere', 'value' => $articlesResubmittedElsewhere],
            ['title' => 'total_authors', 'value' => $total_authors],
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
        switch ($stats_title) {
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
                $data = Publication::with('author')->where('published_at', '!=', null)->get();
                break;
            case 'under_review':
                $data = Manuscript::with('author')->where('status', 'under_review')->get();
                break;
            case 'accepted_articles':
                $data = Manuscript::with('author')->where('status', 'accepted')->get();
                break;
            case 'rejected_articles':
                $data = Manuscript::with('author')->where('status', 'rejected')->get();
                break;
            case 'articles_withdrawn_by_authors':
                $data = Manuscript::with('author')->where('status', 'articles_withdrawn_by_author')->get();
                break;
            case 'total_articles':
                $data = Manuscript::with('author')->get();
                break;
            case 'total_users':
                $data = User::with('user_role')->get();
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
            'roleRequests' => RoleRequest::orderBy('id', 'DESC')->with('user', 'role')->where('status', 'Pending')->get(),
        ]);
    }

    public function role_permission()
    {
        return Inertia::render('Super_Admin/Role_Permissions', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'rolePermissions' => Role::with('permissions')->get()->mapWithKeys(function ($role) {
                return [$role->id => $role->permissions->pluck('id')->toArray()];
            })->toArray()
        ]);
    }

    public function role_permission_update(Request $request)
    {
        $validated = $request->validate([
            'selectedRole' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'boolean'
        ]);

        try {
            $role = Role::findOrFail($validated['selectedRole']);

            $checked = [];
            $unchecked = [];

            foreach ($validated['permissions'] as $permissionId => $isChecked) {
                if ($isChecked) {
                    $checked[] = (int)$permissionId;
                } else {
                    $unchecked[] = (int)$permissionId;
                }
            }

            // Add new permissions without removing existing ones
            if (count($checked)) {
                $role->permissions()->syncWithoutDetaching($checked);
            }

            // Remove only the unchecked permissions
            if (count($unchecked)) {
                $role->permissions()->detach($unchecked);
            }

            return redirect()->route('role_permission_settings')->with('success', 'Permissions updated successfully');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating permissions',
                'error' => $e->getMessage()
            ], 500);
        }
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

            $roleToUpdate = DB::table('model_has_roles')
                ->where('model_id', $request->user_id)
                ->first();

            if ($request->option === 'Accepted') {
                DB::table('model_has_roles')
                    ->where('model_id', $request->user_id)
                    ->update([
                        'role_id' => $request->role_id,
                    ]);
            } else {
                DB::table('model_has_roles')
                    ->where('model_id', $request->user_id)
                    ->update([
                        'role_id' => $defaultRole->id,
                    ]);
            }

            $roleRequested = Role::where('id', $request->role_id)->first();
            Notification::create([
                'notifiable_type' => get_class($roleRequest),
                'notifiable_id' => $roleRequest->id,
                'receiver_id' => $roleRequest->user_id,
                'sender_id' => auth()->id(),
                'message' => 'Your request to be ' . $roleRequested->name . 'has been' . $request->option,
                'status' => false,
            ]);
        });


        $data = RoleRequest::orderBy('id', 'DESC')
            ->with('user', 'role')->where('status', 'pending')
            ->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuperAdminRequest $request)
    {
        //
    }

    public function ubpublishArticle(StoreSuperAdminRequest $request, $publication_id)
    {
        $publication = Publication::findOrFail($publication_id);
        $status = validator($request->publication, [
            'status' => 'required|in:accepted,published'
        ])->validate();
        $publication->status = $status['status'];
        $publication->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $superAdmin)
    {
        //
    }

    public function updateArticleStatus(StoreSuperAdminRequest $request, $publication_id)
    {
        $manuscript = Manuscript::findOrFail($publication_id);
        $newStatus = $request->validate([
            'newStatus' => ['required', 'string', Rule::in('under_review', 'published', 'accepted', 'rejected', 'resubmitted_elsewhere', 'withdrawn_by_author')]
        ]);


        if ($manuscript && ($newStatus['newStatus'] === 'published' || $newStatus['newStatus'] === 'accepted')) {
            $publication = Publication::where('manuscript_id', $manuscript->id)->first();

            if ($publication) {
                // Update existing
                $publication->status = true;
                $publication->save();
                $manuscript->status = $newStatus['newStatus'];
                $manuscript->save();
            } else {
                $publication = Publication::create([
                    'title' => $manuscript->title,
                    'manuscript_id' => $manuscript->id,
//            'review_id'             => $manuscript->author_id,
                    'author_id' => $manuscript->author_id,
//            'editor_id'             => $manuscript->author_id,
                    'abstract' => $manuscript->abstract,
                    'keywords' => $manuscript->keywords,
                    'publication_type_id' => $manuscript->publication_type_id,
                    'category_id' => $manuscript->category_id,
                    'excerpt' => $manuscript->excerpt,
                    'affiliation' => $manuscript->affiliation,
                    'journal' => $manuscript->journal,
                    'final_document' => $manuscript->main_document,
                    'thumbnail' => $manuscript->thumbnail,
                    'figures' => $manuscript->figures,
//            'supplementary'         => $manuscript->supplementary,
//            'cover_letter'          => $manuscript->cover_letter,
//            'ethical_approval'      => $manuscript->ethical_approval ?? null,
//            'conflict_of_interest'  => $manuscript->conflict_of_interest ?? null,
//            'funding_statement'     => $manuscript->funding_statement ?? null,
//            'consent'               => $manuscript->consent,
//            'originality'           => $manuscript->originality,
                    'premium' => $manuscript->premium,
                    'amount' => $manuscript->amount,
                    'co_writers' => $manuscript->co_writers,
//            'reviewed_abstract' => $data['reviewed_abstract'],
                    'citation_information' => $manuscript->citation_information,
                    'status' => true,
                    'published_at' => now()
                ]);
                $publication->save();
                $manuscript->status = $newStatus['newStatus'];
                $manuscript->save();
            }
        } else if ($manuscript) {
            $manuscript->status = $newStatus['newStatus'];
            $manuscript->save();
        } else {
            echo 'invalid publication selected';
        }
        $manuscript = Manuscript::with('author')->get();
        return response()->json($manuscript);
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
    public function viewUser($user_id)
    {
        $user = User::with('publications', 'user_role')->find($user_id);

        return inertia::render('Super_Admin/ViewUser', [
            'user' => $user
        ]);

    }

    public function update(UpdateSuperAdminRequest $request, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pub_id)
    {
        $itemToDelete = Publication::findOrFail($pub_id);
        if ($itemToDelete) {
            $itemToDelete->delete();
        }
    }

    public function deleteUser($user_id)
    {
        $userToDelete = User::findOrFail($user_id);
        if ($userToDelete) {
            $userToDelete->delete();
        }
    }

    public function removeUserRole($user_id)
    {
        $defaultRole = Role::where('name', 'Reader')->first();
        $user = User::findOrFail($user_id);

        if ($user) {
            DB::table('model_has_roles')->where('model_id', $user->id)
                ->update([
                    'role_id' => $defaultRole->id,
                ]);
        }
    }

    public function viewSale($publication_id)
    {
        $sales = Receipt::with('publication.author')->where('publication_id', $publication_id)->get();
        if ($sales) {
            return inertia::render('Super_Admin/ViewSale', [
                'sales' => $sales,
            ]);
        }
    }

    public function viewPublication($publication_id)
    {
        $publication = Manuscript::with('author')->where('id', $publication_id)->first();
        if ($publication) {
            return inertia::render('Super_Admin/ViewPublication', [
                'publication' => $publication,
            ]);
        }
    }

    public function viewPublishedPublication($publication_id)
    {
        $publication = Publication::with(['author', 'reviewer', 'review', 'editor', 'receipts'])->where('id', $publication_id)->first();
        if ($publication) {
            return inertia::render('Super_Admin/ViewPublishedPublication', [
                'publication' => $publication,
            ]);
        }
    }
}
