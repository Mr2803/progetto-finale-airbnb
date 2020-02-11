@extends('layouts.base')

@section("content")
  <div class="container-fluid ">
    <div class="card" style="width: 20rem;">
      <div class="card-body card_center">
        <img class="img-profile" src="https://a0.muscache.com/defaults/user_pic-225x225.png?v=3" alt="Card image cap">
        <div class="card-body">
          <a href="#" class="card-link">Aggiorna foto</a>
        </div>
      </div>
      <div class="card-body">
        <h4 class="card-text"> {{$user ->name}} </h4>
        <p class="card-text"> {{$user -> email}} </p>
      </div>
    </div>
  </div>
  <div >
    <h1>Ciao {{ $user->name }}</h1>
    <a href="#">Modifica il profilo </a>
  </div>
  <div >
    
      <a href="{{ route('userApartment.show',$user -> id) }}">I miei appartamenti({{ $user -> apartments() -> count()}}) </a>
    
  </div>


@endsection
