<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
		$response = $this->postJson('/api/account/create', ['name' => 'Sally Yates', 'balance' => 600]);
        $response->assertSuccessful();
    }
	
	public function testMakeTransaction(){
		$response = $this->postJson('/api/transaction/new', ['from' => 2, 'to' => 1, 'amount' => 10, 'message' => 'test', 'publictxn' => 1]);
        $response->assertSuccessful();
        $response->dumpHeaders();

        $response->dumpSession();

        $response->dump();
	}
}
