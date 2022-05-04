<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
            [

                [
                    'image'=> 'https://theparfumerie.b-cdn.net/wp-content/uploads/2021/08/3274872399020_P011055_GG_EDPB_79_6_100ML_a_01.jpg',
                    'title'=> 'The Only One Intense ops apodegp',
                    'brand'=> 'Dolce & Gabbana',
                    'type'=> 'Eau De Parfum',
                    'size'=> '100',
                    'gender'=> 'Women',
                    'description'=> 'Dolce & Gabbana’s iconic fragrance The One reaches its 
                    highest intensity with Essence. Preserving the distinctive Oriental Floral 
                    mood of The One Eau de Parfum, this rich and concentrated version combines c
                    ontemporary fruity notes with the timeless signature of white flowers.',
                    'stock'=> 100,
                    'price'=> 16900,
                    'discount'=> '%',
                    'discount_number'=> '50',
                    'final_price'=> 8450,
                ],[
                    'image'=> 'https://theparfumerie.b-cdn.net/wp-content/uploads/2021/08/3274872274464_P046202_DDIV_EDP_75ML_a_01.jpg',
                    'title'=> 'The Only One Intense',
                    'brand'=> 'Dolce & Gabbana',
                    'type'=> 'Eau De Parfum',
                    'size'=> '100',
                    'gender'=> 'Women',
                    'description'=> 'Dolce & Gabbana’s iconic fragrance The One reaches its 
                    highest intensity with Essence. Preserving the distinctive Oriental Floral 
                    mood of The One Eau de Parfum, this rich and concentrated version combines c
                    ontemporary fruity notes with the timeless signature of white flowers.',
                    'stock'=> 100,
                    'price'=> 16900,
                    'discount'=> '%',
                    'discount_number'=> '50',
                    'final_price'=> 8450,
                ],[
                    'image'=> 'https://theparfumerie.b-cdn.net/wp-content/uploads/2021/08/3274872400733_P036175_IRRESISTIBLE_EAU-DE-PARFUM_80ml_a_01.jpg',
                    'title'=> 'The Only One Intense',
                    'brand'=> 'Dolce & Gabbana',
                    'type'=> 'Eau De Parfum',
                    'size'=> '100',
                    'gender'=> 'Women',
                    'description'=> 'Dolce & Gabbana’s iconic fragrance The One reaches its 
                    highest intensity with Essence. Preserving the distinctive Oriental Floral 
                    mood of The One Eau de Parfum, this rich and concentrated version combines c
                    ontemporary fruity notes with the timeless signature of white flowers.',
                    'stock'=> 100,
                    'price'=> 16900,
                    'discount'=> '%',
                    'discount_number'=> '50',
                    'final_price'=> 8450,
                    ]         
            ]);
    
    }
}
