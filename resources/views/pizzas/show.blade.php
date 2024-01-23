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
  @if (Auth::check())
    @if (Auth::user()->user_type == 'admin' && $pizza->status !== 'complete')
    <form action="{{ route('pizzas.complete', $pizza->id) }}" method="POST">
      @csrf
      @method('PATCH')
      <button>Complete Order</button>
    </form>
    @endif
  @endif
</div>
<a href="{{ route('pizzas.index') }}" class="back"><- Back to all pizzas</a>
@endsection