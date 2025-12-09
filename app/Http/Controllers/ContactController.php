<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequestForm;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(ContactRequestForm $request)
    {
        // Save in database
        ContactRequest::create([
            'first_name' => $request->firstName,
            'last_name'  => $request->lastName,
            'email'      => $request->email,
            'company'    => $request->company,
            'message'    => $request->message,
        ]);

        return back()->with([
            'success' => "Votre message a été envoyé avec succès."
        ]);
    }
}
