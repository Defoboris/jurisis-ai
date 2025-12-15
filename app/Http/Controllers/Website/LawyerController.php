<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LawyerRequest;
use App\Http\Resources\Admin\LawyerResource;
use App\Http\Resources\Admin\UserResource;
use App\Models\Article;
use App\Models\Lawyer;
use App\Models\User;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LawyerController extends Controller
{

    public function index()
    {
        $lawyers = Lawyer::with('user', 'articles')->where('moderation_state', 'approved')->paginate(6);
        return Inertia::render('Web/Lawyer/Lawyer', [
            'lawyers' => $lawyers
        ]);
    }

    public function lawyerManagement()
    {
        $lawyers = Lawyer::with('user')->get();
        $users = User::whereNot('role', 'admin')->get();

        return Inertia::render('SuperAdmin/LawyerManagement',[
             'lawyers' => LawyerResource::collection($lawyers),
             'users' => UserResource::collection($users),
        ]);
    }

    public function show(Lawyer $lawyer)
    {
        $lawyer->load('user');
        
        $lawyer->articles = Article::published()->latest('published_at')->where('lawyer_id', $lawyer->id)->get(['id', 'title', 'content', 'slug', 'published_at', 'views', 'likes', 'comments_count']);
        return Inertia::render('Web/Lawyer/LawyerDetails', [
            'lawyer' => $lawyer
        ]);
    }

    public function create(LawyerRequest $request)
    {

        Lawyer::create($request->validated());
        
        $user = User::find($request->user_id);
        $user->role = 'lawyer';
        $user->save();
        
        return back()->with('success', 'Lawyer created successfully!');
    }

    public function update(LawyerRequest $request, Lawyer $lawyer)
    {
        $lawyer->update($request->validated());
        return back()->with('success', 'Lawyer updated successfully!');
    }

    public function moderate(Lawyer $lawyer, String $state)
    {
        $lawyer->update(['moderation_state' => $state]);
        return back()->with('success', 'Lawyer updated successfully!');
    }

    public function destroy(Lawyer $lawyer)
    {
        $lawyer->delete();
        return back()->with('success', 'Lawyer deleted successfully!');
    }
}
