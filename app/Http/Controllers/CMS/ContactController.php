<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Contact\ContactFormRequest;
use App\Mail\CMS\Contact\ContactUsMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {

        return view('contact.index');
    }

    public function send(ContactFormRequest $request)
    {
        $data = $request->validated();

        Mail::to('contact@vagaretreat.com')->later(now()->addMinutes(1), new ContactUsMail($data));

        return redirect()->route('contact.index')->with('success', 'Email sent successfully.');
    }
}
