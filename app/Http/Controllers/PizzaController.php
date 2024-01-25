<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pizza;
use Carbon\Carbon;


class PizzaController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
        if ($user && $user->user_type == 'admin')
         {
            $pizzas = Pizza::latest()->get();
        } 
        elseif ($user) 
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

        if (Auth::check())
         {
            
            $user = Auth::user();
            $pizza->user_id = $user->id; 
        }
    
        // to mysql 
        $pizza->save();

        // for auto delete
        CancelOrder::dispatchAfter(now()->addMinutes(5), $pizza->id);

    
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
    public function accept($id)
{
    $pizza = Pizza::findOrFail($id);
    $pizza->update(['status' => 'making']);

    return redirect()->route('pizzas.show', $id)->with('mssg', 'Order accepted! Pizza is now in making.');
}

public function cancel($id)
{
    $pizza = Pizza::findOrFail($id);
    $pizza->update(['status' => 'canceled']);

    return redirect()->route('pizzas.show', $id)->with('mssg', 'Order canceled.');
}

public function dispatch($id)
{
    $pizza = Pizza::findOrFail($id);
    $pizza->update(['status' => 'dispatch']);

    return redirect()->route('pizzas.show', $id)->with('mssg', 'Order dispatched!');
}
public function deliver($id)
{
    $pizza = Pizza::findOrFail($id);
    $pizza->update(['status' => 'delivered']);

    return redirect()->route('pizzas.show', $id)->with('mssg', 'Order delivered!');
}
}