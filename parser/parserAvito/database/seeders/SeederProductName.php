<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederProductName extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = array(
            "noutbuki",
            "telefony",
            "kvartiry",
        );

        for($i = 0; $i<count($arr); $i++){
            DB::table('goods')->insert([
                'product_name' => $arr[$i],
            ]);
        }
    }
}
