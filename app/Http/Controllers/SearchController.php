<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $name = $request->input('search');
        $results = User::where('name', $name)->get();
        $text = '<p>Hello Saja</p>';
        if ($results->isEmpty()) {
            return redirect()->route('home')->with('results', ['No results found for the given name.']);
        }

        return redirect()->route('home')->with('results', $results);

    }

//    public function search(Request $request)
//    {
//        $name = $request->input('search');
//          $results = DB::select("SELECT * FROM users WHERE name = '$name'");
//          $text = '<p>Hello Saja</p>';
//        if (empty($results)) {
//            return redirect()->route('home')->with('results', ['No results found for the given name.']);
//        }
//
//        return redirect()->route('home')->with('results', $results);
//
//    }

}
