<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederReportStatuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = array(
            "В процессе",
            "Готово",
            "Ошибка",
        );

        for($i = 0; $i<count($arr); $i++){
            DB::table('report_statuses')->insert([
                'status_name' => $arr[$i],
            ]);
        }
    }
}
