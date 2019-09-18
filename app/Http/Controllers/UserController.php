<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
	public function index(){

		if (request()->has('empty')){
			$users=[];
		}else{
			$users=User::all();
		}

		$title='Listado de Usuarios';

		return view ('users')
		->with('users',$users)
		->with('title',$title);
	}

	public function show(User $user){
		
		return view('users.show', ['user' => $user]);
	}

	public function create(){
    	
		return view ('users.create');

    }

    public function store(){
    	
    	$data=request()->validate([
    		'name'=>'required',
    		'email'=>'required|email|unique:users',
    		'password'=>'required|min:6'
    	],[
    		'name.required'=>'El campo Nombre es obligatorio'
    	]);

	    //dd($data);

	    User::create([
	    	'name'=>$data['name'],
	    	'email'=>$data['email'],
	    	'password'=>bcrypt($data['password']),
	    ]);

	    return redirect(route('users'));
    }

    public function edit(User $user){

    	return view('users.edit', ['user' => $user]);

    }

    public function update(User $user){

    	$data=request()->validate([
    		'name'=>'required',
    		'email'=>'required|email|unique:users,email,'.$user->id,
    		'password'=>''
    	],[
    		'name.required'=>'El campo Nombre es obligatorio'
    	]);

    	if ($data['password']!=null){
    		$data['password']=bcrypt($data['password']);
    	}else{
    		unset($data['password']);
    	}

    	$user->update($data);

    	//dd($user);//Cambios realizados

    	return redirect()->route('users.show', ['user' => $user]);//
    }

   public function destroy(User $user){

   	//NOTA: QUIERO AGREGAR UN MENSAJE DE ADVERTENCIA ANTES DE HACER EL DELETE

   	$user->delete();

   	return redirect()->route('users');

   }

}
