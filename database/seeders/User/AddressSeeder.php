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
            'user_id'       => 1,
            'title'         => 'Kos',
            'street'        => '123 Main Street',
            'postal_code'   => '123456',
        ]);

        Address::create([
            'user_id'       => 1,
            'title'         => 'Home',
            'street'        => '456 Elm Avenue',
            'postal_code'   => '789456',
        ]);

        // Add more data as needed
    }
}
