<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleRequestController;
use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,id',
        ]);


        DB::transaction(function () use ($request, &$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $selectedRole = Role::findOrFail($request->role);
            if ($selectedRole->name !== 'Reader'){
                RoleRequest::create([
                    'user_id' => $user->id,
                    'role_id' => $request->role,
                    'status' => 'Pending',
                ]);
            }

            $currentRole =  Role::where('name', 'Reader')->first()->id;
            DB::table('model_has_roles')->insert([
                'model_id' => $user->id,
                'role_id' => $currentRole,
                'model_type' => 'App\Models\User',
            ]);
        });
        event(new Registered($user));
        Auth::login($user);

        switch ($user->role) {
            case 'Super_Admin':
                return redirect()->route('admin.dashboard');
            case 'Editor':
                return redirect()->route('editor.dashboard');
            case 'Reviewer':
                return redirect()->route('reviewer.dashboard');
            case 'Author':
                return redirect()->route('author.dashboard');
                case 'Reader':
                return redirect()->route('reader.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Unauthorized role.',
                ]);
        }
    }
}
