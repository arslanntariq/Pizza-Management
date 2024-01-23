


@extends('layouts.app')

@section('data')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <img src="/img/pizza-house.png" alt="pizza house logo">
            <div class="title m-b-md">
                Bawa Pizzas Customer Registration
            </div>

            <div class="links">
                <a href="{{ route('login') }}">Sign In</a>
                <a href="{{ route('register') }}">Sign Up (Regular User)</a>
            </div>

            <form method="POST" action="{{ route('customer.create') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Register as Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
