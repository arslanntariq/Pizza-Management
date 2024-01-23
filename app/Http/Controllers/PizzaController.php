<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class PizzaController extends Controller
{
    // ... existing methods ...

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'base' => 'required',
        ]);

        // Get the currently authenticated user
        $user = auth()->user();

        // Create a new pizza and associate it with the user using the user_id column
        $pizza = Pizza::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'base' => $request->input('base'),
            'toppings' => $request->input('toppings'),
            'status' => 'incomplete',
        ]);

        return redirect('/')->with('mssg', 'Thanks for your order!');
    }

    public function index() {
        $pizzas = Pizza::all();
        // $pizzas = Pizza::orderBy('name', 'desc')->get();
        // $pizzas = Pizza::where('type', 'hawaiian')->get();
       // $pizzas = Pizza::latest()->get();
       return view('pizzas.index', [
          'pizzas' => $pizzas,
        ]);
      }
      public function create()
        {
        
       return view('pizzas.create');
        
    }

    // ... other methods ...
}
