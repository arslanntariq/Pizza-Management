@extends('layouts.layout')

@section('data')
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <img src="/img/pizza-house.png" alt="pizza house logo">
        <div class="title m-b-md">
            Bawa Pizzas
        </div>
        <p class="mssg">{{ session('mssg') }}</p>
        @if(session('pizza_details'))
            <div class="pizza-details">
                <h2>Your Pizza Details</h2>
                <p>Type: {{ session('pizza_details.type') }}</p>
                <p>Base: {{ session('pizza_details.base') }}</p>
                <p>Toppings: {{ implode(', ', session('pizza_details.toppings')) }}</p>
            </div>
            <?php
                session()->forget('pizza_details');
            ?>
        @endif

        <p class="mssg">{{ session('mssg') }}</p>

        <a href="{{ route('pizzas.create') }}">Order a Pizza</a>
    </div>
</div>
@endsection