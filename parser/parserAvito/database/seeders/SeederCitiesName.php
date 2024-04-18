<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederCitiesName extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $arr = array("norilsk",
            "yoshkar-ola",
            "moskva",
            "vladimir",
            "ekaterinburg",
            "velikiy_novgorod",
            "perm",
            "sankt-peterburg",
            "derbent",
            "ivanovo",
            "belgorod",
            "novorossiysk",
            "kazan",
            "volgograd",
            "nizhniy_novgorod",
            "krasnoyarsk",
            "novosibirsk",
            "samara",
            "rostov-na-donu",
            "volgograd",
            "arhangelsk",
            "kaluga",
            "vladikavkaz",
            "murmansk",
            "murom",
            "groznyy",
            "kaliningrad",
            "petrozavodsk",
            "vladivostok",
            "kurgan",
            "maykop",
            "petropavlovsk-kamchatskiy",
            "smolensk",
            "stavropol",
            "arzamas",
            "pyatigorsk",
            "sochi",
            "kamyshin",
            "astrahan",
            "barnaul",
            "pskov",
            "irkutsk",
            "izhevsk",
            "tver",
            "tyumen",
            "kursk",
            "voronezh",
            "novoshahtinsk",
            "omsk",
            "rybinsk",
            "ryazan",
            "chelyabinsk");

        for($i = 0; $i<count($arr); $i++){
            DB::table('cities')->insert([
                'city_name' => $arr[$i],
            ]);
        }
    }
}

