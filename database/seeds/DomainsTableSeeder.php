<?php

use App\Domain;
use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::truncate();

        Domain::create([
            'name' => 'allthebeautifulplaces.info',
        ]);

        Domain::create([
            'name' => 'nxnews.info',
        ]);

        Domain::create([
            'name' => 'mxnews.info',
        ]);

        Domain::create([
            'name' => 'toptennews.info',
        ]);

        Domain::create([
            'name' => 'ttvietnet.info',
        ]);

        Domain::create([
            'name' => 'mnltime.info',
        ]);
    }
}
