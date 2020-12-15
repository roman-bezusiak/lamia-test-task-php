<?php

namespace App\Http\Controllers\WebViews\Search;

use App\Http\Controllers\Auth\AuthGate;
use Illuminate\Http\Request;

class BookSearchViewController extends AuthGate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        // Authentication check
        if(!$this->authenticated())
        {
            return redirect()->route('login_page');
        }

        return view('search.book_search');
    }
}
