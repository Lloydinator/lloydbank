<?php

use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            'name' => 'John Hubert',
            'balance' => 15000,
            'currency_id' => 1,
        ]);

        DB::table('accounts')->insert([
            'name' => 'Pyotr Henkel',
            'balance' => 100000,
            'currency_id' => 2
        ]);
    }
}
