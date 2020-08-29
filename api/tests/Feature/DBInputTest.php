<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DBInputTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
	
	use RefreshDatabase;
	
    public function testMakeNewAccount(){
		$response = $this->postJson('/api/account/create', ['name' => 'Sally', 'balance' => 600]);
		
        $response
            ->assertSuccessful();
    }
	/*
	public function testMakeNewAccountThenTxn(){
		$account = factory(\App\Account::class)->create();
		$from = mt_rand(200,20000);
		$to = mt_rand(200,20000);
		
		$data = [
			'from' => $from,
			'to' => $to,
			'amount' => mt_rand(10,2000),
			'currency_id' => 1,
			'message' => 'Does it work'
		];
		$response = $this->postJson('/api/transaction/account/{$from}', $data)
						->assertSuccessful();
		
	}
	*/
}
