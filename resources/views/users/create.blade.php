@extends('layouts.layout')

@yield('header')

@section('title')
    <title>Crear Nuevo Usuario</title>
@endsection

@section('content')

    @section('contentTitle')
        <h1 class="mt-5">Crear Nuevo Usuario</h1>
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

        <form method="POST" action="{{url('usuarios/crear')}}">

            {!!csrf_field()!!}

            {{ method_field('POST') }}

           <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{old('name')}}" placeholder="Nombre Apellido" class="form-control"/>
          </div> 
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{old('email')}}" placeholder="email@valido.com" class="form-control"/>
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