<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product=\App\Product::create([
            'name'=>'Black T-Shirt',
            'price'=>100,
            'photo'=>'Default-Tshirt.JPEG',
        ]);
    }
}
