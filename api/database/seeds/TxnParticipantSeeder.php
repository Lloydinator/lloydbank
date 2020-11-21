<?php

use Illuminate\Database\Seeder;

class TxnParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TxnParticipant::class, 30)->create();
    }
}
