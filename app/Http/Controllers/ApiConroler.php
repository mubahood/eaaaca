<?php

use App\Http\Controllers\Controller;

class ApiConroler extends Controller
{
    public function index(){
        return response()->json(['message' => 'API is running']);
    }
}
