<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class RankingViewController extends Controller
{
    public function get(Request $request) {
        return view('rankings');
    }

    public function staticGet(Request $request) {
        return view('static_rankings');
    }
}
