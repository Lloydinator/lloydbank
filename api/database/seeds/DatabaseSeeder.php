<?php

use App\TxnParticipant;
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
        $this->call(AccountsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(TxnParticipantSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
