<?php

use Illuminate\Database\Seeder;
use App\Club;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Clubs = [
            ["AJAX", 25, 2],
            ["PSV", 23, 1],
            ["WILLEM II", 21, 5],
            ["FEYENOORD", 23, 3],
            ["VVV", 20, 4]
        ];

        foreach ($Clubs as $data) {
            $Club = new Club;
            $Club->naam = $data[0];
            $Club->aantal_spelers = $data[1];
            $Club->positie = $data[2];
            $Club->save();
        }
    }
}
