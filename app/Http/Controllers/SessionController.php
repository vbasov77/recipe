<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function addSession(Request $request)
    {
        $request->session()->put('userId', 1);
        $request->session()->save();
    }
}