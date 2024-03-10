<?php

namespace App\Http\Controllers;
use App\Models\TranslateUsers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function updateText($id, Request $request)
    {
        $text = $request->input('text');

        $item = TranslateUsers::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $item->english_translation = $text;
        $item->save();

        return response()->json(['success' => true]);
    }
}
