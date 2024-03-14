<?php

namespace Database\Seeders;

use App\Models\TranslateUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class translationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $csvFile = file("D:/translate_users.csv");
        $data = array_map("str_getcsv", $csvFile);

        Log::info($data);
        foreach ($data as $row) {
            TranslateUsers::create([
                "id" => $row[0],
                "item_code" => $row[1],
                "arabic_translation" => $row[2],
                "english_translation" => $row[3],
                "username" => $row[4],
            ]);
        }
    }
}
