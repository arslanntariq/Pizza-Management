@extends('layouts.app')

@section('data')
<div class="wrapper pizza-details">
    <h1>Order for {{ $pizza->name }}</h1>
    <p class="type">Type - {{ $pizza->type }}</p>
    <p class="base">Base - {{ $pizza->base }}</p>
    <p class="toppings">Extra toppings:</p>
    <ul>
        @foreach($pizza->toppings as $topping)
        <li>{{ $topping }}</li>
        @endforeach
    </ul>

    <p>Status: {{ $pizza->status }}</p>

    <p>Created At: {{ $pizza->created_at }}</p>
    <p>Updated At: {{ $pizza->updated_at }}</p>
    
    @if (Auth::check() && Auth::user()->user_type == 'user')
        @if ($pizza->status == 'waiting')
            @php
                $currentTime = now();
                $orderTime = $pizza->created_at;
                $isWithin5Minutes = $currentTime->diffInMinutes($orderTime) <= 5;
            @endphp

            @if ($isWithin5Minutes)
                <form action="{{ route('pizzas.cancel', $pizza->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit">Cancel Order</button>
                </form>
            @endif
        @endif
    @endif


    @if (Auth::check() && Auth::user()->user_type == 'admin')
        @if ($pizza->status == 'waiting')
            <form action="{{ route('pizzas.accept', $pizza->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Accept Order</button>
            </form>

            <form action="{{ route('pizzas.cancel', $pizza->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Cancel Order</button>
            </form>
        @elseif ($pizza->status == 'making')
            <form action="{{ route('pizzas.dispatch', $pizza->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Dispatch Order</button>
            </form>
        @elseif ($pizza->status == 'dispatch')
            <form action="{{ route('pizzas.deliver', $pizza->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit">Deliver Order</button>
            </form>
        @elseif ($pizza->status == 'delivered')
            <p>Order Delivered!</p>
        @endif
    @endif

    <a href="{{ route('pizzas.index') }}" class="back"><- Back to all pizzas</a>
</div>
@endsection
