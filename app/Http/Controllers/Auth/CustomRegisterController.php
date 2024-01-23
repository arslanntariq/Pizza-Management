// app/Http/Controllers/Auth/CustomRegisterController.php
<?php
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class CustomRegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    public function showRegistrationForm()
    {
        return view('auth.custom-register');
    }

    protected function create(array $data)
    {
        // Save only to the customers table
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
