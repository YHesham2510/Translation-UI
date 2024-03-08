<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\TranslateUsers;

class TranslateUserController extends Controller
{
    //
    public function index()
    {
        $translateUsers = TranslateUsers::all();
        return response()->json(['data' => $translateUsers]);
    }

}
