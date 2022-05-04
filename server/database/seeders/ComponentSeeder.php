<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('components')->insert(
        [
            [
                'sequence'=> 1,
                'thumbnail'=> 'https://unsplash.com/photos/2b0JeJTEclQ',
                'name'=> 'Cariusel_1',
                'size'=> '400'
            ],[
                'sequence'=> 2,
                'thumbnail'=> 'https://unsplash.com/photos/2b0JeJTEclQ',
                'name'=> 'Cariusel_2',
                'size'=> '500'
            ],[
                'sequence'=> 3,
                'thumbnail'=> 'https://unsplash.com/photos/2b0JeJTEclQ',
                'name'=> 'Cariusel_3',
                'size'=> '600'
                ]         
        ]);
    }
}
