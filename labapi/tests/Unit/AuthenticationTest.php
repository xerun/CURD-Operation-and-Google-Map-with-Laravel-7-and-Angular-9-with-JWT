<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $user = new User([
            'name'      =>  'Test',
            'email'     =>  'test@email.com',
            'password'  =>  '123456'
        ]);

        $user->save();
    }

    /** @test */
    public function testRegister()
    {
        $response = $this->post('api/register', [
            'name'      =>  'Test2',
            'email'     =>  'test2@email.com',
            'password'  =>  '123456'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'password',
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }

    /** @test */
    public function testLogin()
    {
        $response = $this->post('api/login', [
            'email'     =>  'test@email.com',
            'password'  =>  '123456'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'password',
                'access_token',
                'token_type',
                'expires_in'
            ]);
    }

    /** @test */
    public function testInvalidLogin()
    {
        $response = $this->post('api/login', [
            'email'     =>  'test@email.com',
            'password'  =>  'notlegitpassword'
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'error',
            ]);
    }
}