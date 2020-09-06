<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use WithFaker;

    private $password = "mypassword";
    
    public function testUserCreation()
    {
       	
       	$name = $this->faker->name();
       	$email = $this->faker->email();

        $response = $this->postJson('/api/register', [
            'name' => $name, 
            'email' => $email,
            'password' => $this->password, 
            'c_password' => $this->password
        ]); 


        $response
            //->assertStatus(201)
            ->assertJson([
                "message" => "Successfully created user!",
            ]);
    }//testUserCreation
}
