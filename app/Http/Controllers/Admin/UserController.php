<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $users = User::where(function ($query) {
            $query->where('role', 'member')
                ->orWhere('role', 'visitor');
        })->get();

        $users = $users->map(function ($user) {


            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status === 'active' ? 'Actif' : 'Inactif',
                'joinDate' => $user->created_at
                    ? Carbon::parse($user->created_at)->format('d/m/Y')
                    : null,
            ];
        });
        return Inertia::render('SuperAdmin/UserManagement', ['users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        User::create($request->validated() + ['password'=>bcrypt('password')]);
        return back()->with('success','User created');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return back()->with('success','User updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','User deleted');
    }

    /**
     * Suspend the given user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suspend(User $user)
    {
        $user->update(['status'=>'suspended']);
        return back()->with('success','User suspended');
    }

    /**
     * Activate the given user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsuspend(User $user)
    {
        $user->update(['status'=>'active']);
        return back()->with('success','User active again');
    }
}
