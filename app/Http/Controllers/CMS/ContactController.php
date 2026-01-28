<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        //Mail::to('contact@vagaretreat.com')->send(new ContactUsMail($data));
        //Mail::to('contact@vagaretreat.com')->queue(new ContactUsMail($data));
        Mail::to('contact@vagaretreat.com')->later(now()->plus(minutes: 1), new ContactUsMail($data));

        if (empty(Mail::flushMacros())) {
            return  redirect(route('contact.index'))->with('success', 'email send');
        }
    }
}
