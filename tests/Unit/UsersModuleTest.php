<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\DB;

class UsersModuleTest extends TestCase
{


    /**
    *@test
    */
    function testExample()
    {
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Usuarios');
    }
    /**
    *@test
    */
    function it_shows_the_users_list()
    {

        /*$this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de Usuarios')
        ->assertSee('Do')
        ->assertSee('Re')
        ->assertSee('Mi')
        ->assertSee('Fa')
        ->assertSee('Sol')
        ->assertSee('La')
        ->assertSee('Si')
        ->assertSee('<script>$kad="123321"</script>');*/

        factory (User::class)->create([
            'name'=>'Joel',
        ]);

        factory (User::class)->create([
            'name'=>'Ellie',
        ]);

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de Usuarios')
        ->assertSee('Joel')
        ->assertSee('Ellie');
        

    }


    /**
    *@test
    */
    function it_shows_a_default_message_if_the_users_list_is_empty()
    {
        $response=DB::table('users')->truncate();

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de Usuarios')
        ->assertSee('No hay usuarios registrados');
    }

    /**
    *@test
    */
    function it_shows_no_users_registered()
    {
        $this->get('/usuarios?empty')
        ->assertStatus(200)
        ->assertSee('Listado de Usuarios')
        ->assertSee('No hay usuarios registrados');
    }
    
    /**
    *@test
    */
    function it_loads_the_user_details_page()
    {
        $user=factory (User::class)->create([
            'name'=>'Kadievka Salcedo',
        ]);

        $this->get('/usuarios/'.$user->id)
        ->assertStatus(200)
        ->assertSee('Kadievka Salcedo')
        ->assertSee('Detalles del Usuario #'.$user->id);

        $response=DB::table('users')->truncate();
    }

    /**
    *@test
    */
    function it_displays_a_404_error_if_the_user_is_not_found()
    {
        $this->get('/usuarios/999')
        ->assertStatus(404)
        ->assertSee('Página no encontrada');
    }


    /**
    *@test
    */

    function it_creates_a_new_user(){
        
        //$this->withoutExceptionHandling();

        $this->post('/usuarios/crear',[
            'name'=>'Ren',
            'email'=>'ren@example.com',
            'password'=>bcrypt('123456')
        ])->assertRedirect('/usuarios');

        $this->assertDatabaseHas('users',[
            'name'=>'Ren',
            'email'=>'ren@example.com'
        ]);

        $response=DB::table('users')->truncate();

    }


    /**
    *@test
    */

    function the_name_is_required(){
        $this->from('/usuarios/nuevo')
        ->post('/usuarios/crear',[
            'name'=>'',
            'email'=>'ren@example.com',
            'password'=>bcrypt('123456')
        ])->assertRedirect('/usuarios/nuevo')
        ->assertSessionHasErrors(['name']);

        $this->assertEquals(0,User::count());
    }

    /**
    *@test
    */

    function the_email_is_required(){
        $this->from('/usuarios/nuevo')
        ->post('/usuarios/crear',[
            'name'=>'Ren',
            'email'=>'',
            'password'=>bcrypt('123456')
        ])->assertRedirect('/usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

        $this->assertEquals(0,User::count());
    }


    /**
    *@test
    */

    function the_email_must_be_unique(){

        $user=factory (User::class)->create([
            'name'=>'Kadievka Salcedo',
            'email'=>'kadievka.s@example.com'
        ]);

        $this->from('/usuarios/nuevo')
        ->post('/usuarios/crear',[
            'name'=>'Ren',
            'email'=>'kadievka.s@example.com',
            'password'=>'',
        ])->assertRedirect('/usuarios/nuevo')
        ->assertSessionHasErrors(['email']);

        $this->assertEquals(1,User::count());

        $response=DB::table('users')->truncate();
    }

    /**
    *@test
    */

    function the_password_is_required(){
        $this->from('/usuarios/nuevo')
        ->post('/usuarios/crear',[
            'name'=>'Ren',
            'email'=>'ren@example.com',
            'password'=>'',
        ])->assertRedirect('/usuarios/nuevo')
        ->assertSessionHasErrors(['password']);

        $this->assertEquals(0,User::count());
    }

    
    /**
    *@test
    */

    function the_password_must_have_at_least_6_characters(){
        $this->from('/usuarios/nuevo')
        ->post('/usuarios/crear',[
            'name'=>'Ren',
            'email'=>'ren@example.com',
            'password'=>'s1.',
        ])->assertRedirect('/usuarios/nuevo')
        ->assertSessionHasErrors(['password']);

        $this->assertEquals(0,User::count());
    }

    /**
    *@test
    */

    function it_loads_the_edit_user_page(){
        
        //$this->withoutExceptionHandling();

        $user=factory (User::class)->create();

        /*$this->get('/usuarios/'.$user->id.'/editar')
        ->assertStatus(200)
        ->assertSee('Editar los datos del usuario #'.$user->id);

        $this->assertEquals(1,User::count());

        $response=DB::table('users')->truncate();*/

        $this->get("/usuarios/{$user->id}/editar")
           ->assertStatus(200)
            ->assertSee('Editar los datos del usuario #'.$user->id)
            ->assertViewHas('user', function ($viewUser) use ($user) {
                return $viewUser->id === $user->id; //esto se hace para evitar un error en cuanto a la vista y al controlador
            })
           ->assertViewIs('users.edit');

            $this->assertEquals(1,User::count());

            $response=DB::table('users')->truncate();

    }

    /**
    *@test
    */

    function it_updates_an_user(){
        
        $user=factory (User::class)->create([
            'name'=>'Sara',
            'email'=>'sara@example.com',
            'password'=>'swefgrgrrwe',
        ]);

        //$this->withoutExceptionHandling();

        //dd($user);

        $this->put("/usuarios/{$user->id}",[
            'name'=>'Ren Honjo',
            'email'=>'ren@example.com',
            'password'=>'123456789',
        ])->assertRedirect("/usuarios/{$user->id}");

        $this->assertDatabaseHas('users',[
            'name'=>'Ren Honjo',
            'email'=>'ren@example.com'
        ]);

        $this->assertEquals(1,User::count());

        $response=DB::table('users')->truncate();

    }

    /**
    **@test
    */

    function the_name_is_required_when_updating_an_user(){
        
        $user=factory (User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name'=>'',
                'email'=>'ren@example.com',
                'password'=>'123456789'
            ])->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);

            $this->assertDatabaseMissing('users',['email'=>'ren@example.com']);
            $this->assertEquals(1,User::count());

            $response=DB::table('users')->truncate();
    }

    /**
    **@test
    */

    function the_password_is_optional_when_updating_an_user(){

        $oldPassword='CLAVE ANTERIOR';
        
        $user=factory (User::class)->create([
            'password'=>bcrypt($oldPassword),
        ]);

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name'=>'Ren',
                'email'=>'ren@example.com',
                'password'=>''
            ])->assertRedirect("/usuarios/{$user->id}");

            $this->assertEquals(1,User::count());

            $response=DB::table('users')->truncate();
    }

    /**
    **@test
    */

    function the_email_can_stay_the_same_when_updating_an_user(){
        
        $user=factory (User::class)->create([
            'email'=>'ren@example.com',
        ]);

        //dd('nombre inicial:'.$user['name'].' '.$user['email']);

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name'=>'Inuyasha',
                'email'=>'ren@example.com',
                'password'=>'123456789'
            ])->assertRedirect("/usuarios/{$user->id}");

            $this->assertEquals(1,User::count());

            //dd('nombre final:'.$user['name'].' '.$user['email']);

            $this->assertDatabaseHas('users',[
                'name'=>'Inuyasha',
                'email'=>'ren@example.com'
            ]);
            $response=DB::table('users')->truncate();
    }

    /**
    **@test
    */
    function it_deletes_an_user(){

        $this->withoutExceptionHandling();

        $user = factory (User::class)->create();

        $this->delete("/usuarios/{$user->id}")
        ->assertRedirect('/usuarios');
        
        $this->assertDatabaseMissing('users',['id'=>$user->id]);
    }

}