<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'title'=>'Deserunt amet minim minim est.',
            'price'=> 19.03,
            'quantity'=> 3,
            'category_id'=>1,
            'brand_id'=>1,
            'description' => 'Ea deserunt nisi pariatur labore deserunt deserunt nisi in Lorem occaecat culpa esse. Ea duis ex proident do non tempor. Eu proident ut proident sunt veniam incididunt. Culpa officia irure aliquip reprehenderit nisi laboris excepteur commodo deserunt excepteur ad ipsum nisi ad. Ut sunt fugiat aute consequat. Occaecat sint consectetur eu esse sit ex elit irure enim Lorem nulla velit ipsum. Dolore laboris in enim nisi voluptate occaecat eu minim occaecat.',
        ]);
    }
}
