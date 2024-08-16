@extends('layouts.header')

@section('content')


    <div class="container home-container">
       

        <h1>Welcome to Enigma Inventory</h1>
      
         <!-- Logo -->
         <img src="{{ asset('storage/LeKaailogo3.jpg') }}" alt="App Logo" class="app-logo">

        <div class="links">
            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        </div>
    </div>


@endsection



