<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TranslateUsers;
use Auth;

class TranslateUserController extends Controller
{

    public function index()
    {


        if (Auth::check()) {
            $username = Auth::user()->name;
            $userTranslationData = TranslateUsers::where('username', $username)->get();
            return response()->json(['data' => $userTranslationData]);
        }
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    public function getBooleanValue($itemId)
    {

        $translation = TranslateUsers::findOrFail($itemId);
        $booleanValue = $translation->is_updated;
        return response()->json(['is_updated' => $booleanValue]);
    }


}
