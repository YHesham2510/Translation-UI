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
        $booleanValue = $request->input('booleanValue');
        $item = TranslateUsers::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        $item->is_updated = $booleanValue;
        $item->english_translation = $text;
        $item->save();

        return response()->json(['success' => true]);
    }
}
