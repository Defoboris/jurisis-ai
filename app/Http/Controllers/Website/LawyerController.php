<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LawyerController extends Controller
{
    public function index()
    {
        return Inertia::render('Web/Lawyer/Lawyer');
    }

    public function show()
    {
        return Inertia::render('Web/Lawyer/LawyerDetails');
    }
}
