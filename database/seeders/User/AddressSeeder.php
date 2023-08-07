<?php

namespace Database\Seeders\User;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run()
    {
        Address::create([
            'user_id' => 1,
            'address' => '123 Main Street',
        ]);

        Address::create([
            'user_id' => 1,
            'address' => '456 Elm Avenue',
        ]);

        // Add more data as needed
    }
}
