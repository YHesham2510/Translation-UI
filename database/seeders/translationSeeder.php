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
        $csvFile = file("D:/translation.csv");
        $data = array_map("str_getcsv", $csvFile);

        Log::info($data);
        foreach ($data as $row) {
            TranslateUsers::create([
                
                "item_code" => $row[0],
                "arabic_translation" => $row[1],
                "english_translation" => $row[2],
                "username" => $row[3],
            ]);
        }
    }
}
