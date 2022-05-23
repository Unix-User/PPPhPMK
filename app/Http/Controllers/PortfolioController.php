<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;


class PortfolioController extends Controller
{
    public function development()
    {
        return view('home.development');
    }

    public function contact()
    {
        return view('home.contact');
    }

    // send contact email
    public function send(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'category' => 'required',
            'message' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'category' => $request->category,
            'message' => $request->message
        );
        Mail::to('wevertonslima@gmail.com')->send(new Contact($data));
        return redirect()->back()->with('success', 'Email sent successfully!');
    }

    public function isp()
    {
        return view('home.isp');
    }

}
