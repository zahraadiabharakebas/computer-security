<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionExpiredController extends Controller
{
    public function index()
    {
        return view('pages.session-expired');
    }
}
