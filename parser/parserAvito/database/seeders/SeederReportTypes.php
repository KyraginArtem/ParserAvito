<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederReportTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = array(
            "Выборка по наименованию",
            "Новые товары",
            "Закрытые объявления",
        );

        for($i = 0; $i<count($arr); $i++){
            DB::table('report_types')->insert([
                'report_name' => $arr[$i],
            ]);
        }
    }
}
