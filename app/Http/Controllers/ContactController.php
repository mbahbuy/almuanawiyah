<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{

    public function index()
    {
        return view('dashboard.contact.index',[
            'title' => 'Email Sender',
            'emails' => Contact::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        Contact::create($request->all());

        return redirect('/#contact')->with(['success' => 'Terimakasih atas pesan yang telah anda kirimkan!!!']);
    }

}