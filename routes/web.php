<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#main page
Route::get('/', function () {
    return view('welcome');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('show');
});


#pizza view using PizzaController
Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index')->middleware('auth');

Route::get('/pizzas/create', [PizzaController::class, 'create'])->name('pizzas.create');
Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');
#wildcards using PizzaController
Route::get('/pizzas/{id}', [PizzaController::class, 'show'])->name('pizzas.show')->middleware('auth');
// ... (existing routes)
Route::patch('/pizzas/{id}/complete', [PizzaController::class, 'complete'])->name('pizzas.complete');
// ... (existing code)

Route::get('/register/customer', 'Auth\RegisterController@showCustomerRegistrationForm')->name('customer.register');
Route::post('/register/customer', 'Auth\RegisterController@createCustomer')->name('customer.create');
// routes/web.php




Auth::routes();
//'register' => false,

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');