@extends('layouts.layout')

@yield('header')

@section('title')
    <title>Detalles del Usuario</title>
@endsection

@section('content')

    @section('contentTitle')
        <h1 class="mt-5">Detalles del Usuario #{{$user->id}}</h1>
    @endsection

    <form>

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{$user->name}}"  class="form-control" disabled="disabled"/>
        </div> 
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{$user->email}}" class="form-control" disabled="disabled"/>
            <small id="emailHelp" class="form-text text-muted">Tu email es completamente privado.</small>
        </div>
        <div class="form-group">
            <label for="profession">Profesión</label>

            @if($user->profession['title']==null)
                <input type="text" name="profession" id="profession" value="Sin Profesión" class="form-control" disabled="disabled"/>
            @else
                <input type="text" name="profession" id="profession" value="{{$user->profession['title']}}" class="form-control" disabled="disabled"/>
            @endif

        </div>
          
        <a class="btn btn-primary" href="{{url('/usuarios/')}}">Regresar</a>

    </form>

@endsection

@yield('footer')