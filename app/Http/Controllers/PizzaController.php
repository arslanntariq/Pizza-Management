<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pizza;

class PizzaController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
        if ($user && $user->user_type == 'admin')
         {
            $pizzas = Pizza::latest()->get();
        } elseif ($user) 
        {
            $pizzas = $user->pizzas()->latest()->get();
        } else 
        {  
            $pizzas = collect(); 
        }
        return view('pizzas.index', [
            'pizzas' => $pizzas,
        ]);
    }

    public function show($id)
    {
        $pizza = Pizza::findOrFail($id);
        return view('pizzas.show', ['pizza' => $pizza]);
    }

    public function create()
    {
        return view('pizzas.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'base' => 'required',
        ]);
    
        $pizza = new Pizza();
        $pizza->name = $request->input('name');
        $pizza->type = $request->input('type');
        $pizza->base = $request->input('base');
        $pizza->toppings = $request->input('toppings');

        if (Auth::check()) {
            // Associate the pizza with the currently authenticated user
            $user = Auth::user();
            $pizza->user_id = $user->id; // Assuming user_id is the foreign key in the pizzas table
        }
    
        // to mysql 
        $pizza->save();
    
        // save in  session
        $request->session()->put('pizza_details', [
            'type' => $request->input('type'),
            'base' => $request->input('base'),
            'toppings' => $request->input('toppings'),
    
        ]);
    
        return redirect('/')->with('mssg', 'Thanks for your order!');
    }
    

    public function destroy($id)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->delete();

        return redirect('/pizzas');
    }
    public function complete($id)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->update(['status' => 'complete']);

        return redirect('/pizzas');
    }
}