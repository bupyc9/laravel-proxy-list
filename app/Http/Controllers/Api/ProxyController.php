<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Proxy;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function index(Request $request)
    {
        $items = Proxy::get();

        return \response($items->toArray());
    }
}
