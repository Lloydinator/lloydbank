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
	/* Needs authentication
    public function testFetchingAccountsFromDatabase(){
        $this->getJson('/api/accounts/all')
			->assertStatus(200);
    }	
	
	public function testFetchingTxnFromDatabase(){
		$this->getJson('/api/transactions/account/1')
			->assertStatus(200);
    }
    */
}
