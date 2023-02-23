<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create([
            'name' => 'Timedoor Indonesia',
        ]);

        $user = $account->users()->create([
            'first_name' => 'Timedoor',
            'last_name'  => 'Indonesia',
            'email'      => 'demo@timedoor.net',
            'password'   => 'demo123',
            'owner'      => true,
        ]);

        User::factory()->count(100)->create([
            'account_id' => $account->id,
        ]);
    }
}
