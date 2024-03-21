<?php

namespace App\Http\Controllers;

use App\Models\TranslateUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    //
    public function updateText($id, Request $request)
    {
        $text = $request->input('text');
        $booleanValue = $request->input('booleanValue');
        // $arabic = $request->input('arabic');
        $item = TranslateUsers::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        // $item->arabic_translation = $arabic;
        $item->is_updated = $booleanValue;
        $item->english_translation = $text;
        $item->save();
        return response()->json(['success' => true, 'data' => $item]);
    }
}
