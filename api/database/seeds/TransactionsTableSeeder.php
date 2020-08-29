<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            'from' => 1,
            'to' => 2,
            'details' => 'sample transaction',
            'amount' => 14,
			'currency_id' => 1,
			'message' => 'Tell your mom hi for me'			
        ]);

        DB::table('transactions')->insert([
            'from' => 1,
            'to' => 2,
            'details' => 'sample transaction 2',
            'amount' => 24,
			'currency_id' => 1,
			'message' => 'This is for dinner the other day'
        ]);

        DB::table('transactions')->insert([
            'from' => 2,
            'to' => 1,
            'details' => 'sample transaction 3',
            'amount' => 15,
			'currency_id' => 1,
			'message' => 'IOU like 10 more'
        ]);
    }
}
