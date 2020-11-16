<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\Rules\DatabaseRule;
use Tests\TestCase;
use App\User;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseMigrations;
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        $user = new User([
            'name' => 'Test Mane',
            'email' => 'test@email.com',
            'password' => '1234'
        ]);

        $user->save();
    }

    public function testRegisteringANewUser(){
        $response = $this->post('api/register', [
            'name' => 'Test Manesha',
            'email' => 'test2@email.com',
            'password' => 'abcd'
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    /*
    public function testLoggingInAUser(){
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => '1234'
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    public function testRejectingAnInvalidUser(){
        $response = $this->post('api/auth/login', [
            'email' => 'test@email.com',
            'password' => 'whatdoesrandygottadotogetadatewitchu'
        ]);

        $response->assertJsonStructure([
            'error',
        ]);
    }
    */
}
