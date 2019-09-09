<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemsViewController extends Controller
{
    public function get(Request $request)
    {
        $uri = action('ItemController@list', ['page' => 1, 'limit' => 1000], false);

        $response = HttpHelpers::get($uri);
        $json = HttpHelpers::bodyToJson($response);
        $items = $json->data;
        $totalItems = $json->count;

        //pass param to view
        return view('items', ["players" => $items, 'count' => $totalItems]);
    }
}
