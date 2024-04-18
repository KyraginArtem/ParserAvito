<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederAdStatuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = array(
            "Активное",
            "Снято с продажи",
        );

        for($i = 0; $i<count($arr); $i++){
            DB::table('ad_statuses')->insert([
                'status_name' => $arr[$i],
            ]);
        }
    }
}
