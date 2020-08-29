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
	 
	use RefreshDatabase;
	 
    public function testFetchingAccountsFromDatabase(){
        $this->getJson('/api/transactions/all')
			->assertStatus(200);
    }

	public function testFetchingTxnFromDatabase(){
		$this->getJson('/api/transactions/all')
			->assertStatus(200);
	}
	
	public function testFetchingCurrenciesFromDatabase(){
		$this->getJson('api/currencies')
			->assertStatus(200);
	}
}
