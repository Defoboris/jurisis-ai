<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LawyerRequest;
use App\Models\Lawyer;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LawyerController extends Controller
{
    public function index()
    {
        $lawyers = Lawyer::with('user')->paginate(6);
        return Inertia::render('Web/Lawyer/Lawyer', [
            'lawyers' => $lawyers
        ]);
    }

    public function show()
    {
        return Inertia::render('Web/Lawyer/LawyerDetails');
    }

    public function create(LawyerRequest $request)
    {
        Lawyer::create($request->validated());
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
