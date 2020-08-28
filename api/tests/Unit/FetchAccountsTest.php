<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchAccountsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
	use RefreshDatabase;
	
    public function testFetchingAccountsFromDatabase()
    {
        $response = $this->json('GET', '/api/accounts');
		$response->assertStatus(200);
		$response->dump();
    }
}
