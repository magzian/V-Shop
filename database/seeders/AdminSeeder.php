<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Creating an admin
        User::create([
            'name'=> 'Admin',
            'email'=>'admin@vshop.com',
            'password'=> Hash::make('12345678'),
            'isAdmin'=>1,
        ]);

        

    }
}
