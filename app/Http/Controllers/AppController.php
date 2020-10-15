<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Str;
use Auth;
use Mail;
use Session;
use Response;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function login(Request $request)
    {
        Auth::guard('app')->basic('username');

        $token = Str::random(60);
        Auth::guard('app')->user()->update([
            'token' => $token
        ]);

        return Response::json([
            'status' => 'success',
            'token' => $token
        ]);
    }

    public function contactus(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'feedback' => ['required', 'min:6']
        ]);

        Mail::to('hkk710@gmail.com')->send(new ContactUsMail($request->all()));

        Session::flash('succes', 'Feedback was successfully submiteed');
        return redirect()->back();
    }
}
