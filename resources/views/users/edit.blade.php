@extends('layouts.layout')

@yield('header')

@section('title')
    <title>Editar Usuario</title>
@endsection

@section('content')

    @section('contentTitle')
        <h1 class="mt-5">Editar los datos del usuario #{{$user->id}}</h1>
    @endsection

        @if($errors->any())
            <div class="alert alert-danger">
                <h6>Por favor, corregir los siguientes errores:</h6>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{url('/usuarios/'.$user->id)}}">

            {!!csrf_field()!!}

            {{ method_field('PUT') }}

           <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{$user->name}}" placeholder="Nombre Apellido" class="form-control"/>
          </div> 
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{$user->email}}" placeholder="email@valido.com" class="form-control"/>
            <small id="emailHelp" class="form-text text-muted">Tu email es completamente privado.</small>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" value="" placeholder="mínimo 6 digitos" class="form-control"/>
          </div>
          <button type="submit" class="btn btn-primary">Aceptar</button>
          <a class="btn btn-primary" href="{{url()->previous()}}">Regresar</a>

        </form>

@endsection

@yield('footer')