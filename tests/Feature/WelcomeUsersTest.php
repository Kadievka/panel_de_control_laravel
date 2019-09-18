<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     *
     * @test*/


    function it_welcomes_users_with_nickname()
    {
        $this->get('/saludo/kadievka/kadi')
        ->assertStatus(200)
        ->assertSee('Bienvenido kadievka, tu apodo es: kadi');
    }
    /**
     * @test*/


    function it_welcomes_users_without_nickname()
    {
        $this->get('/saludo/kadievka')
        ->assertStatus(200)
        ->assertSee('Bienvenido kadievka, no tienes apodo');
    }
}
