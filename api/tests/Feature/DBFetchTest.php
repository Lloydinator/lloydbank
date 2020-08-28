<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DBFetchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFetchAccountsFromDatabase(){
        $this->getJson('/api/accounts')
			->assertStatus(200)
			->assertJson([
				'id',
				'name',
				'balance'
			]);
    }
	/*
	public function testFetchTxnFromDatabase(){
		$this->getJson('/api/{id}/transactions')
			->assertStatus(200)
			->assertJson([
				'id',
				'from',
				'to',
				'details',
				'amount',
				'messages'
			]);
	}
	
	public function testFetchCurrenciesFromDatabase(){
		$this->getJson('api/currencies')
		->assertStatus(200)
		->assertJson([
			'id',
			'name',
			'usForex'
		]);
	}
	*/
}
