<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
			'name' => 'usd',
			'usForex' => 1
		]);
		
		DB::table('currencies')->insert([
			'name' => 'jpy',
			'usForex' => 105
		]);
		
		DB::table('currencies')->insert([
			'name' => 'gbp',
			'usForex' => 0.75
		]);
		
		DB::table('currencies')->insert([
			'name' => 'eur',
			'usForex' => 0.84
		]);
		
		DB::table('currencies')->insert([
			'name' => 'cny',
			'usForex' => 6.86
		]);
    }
}
