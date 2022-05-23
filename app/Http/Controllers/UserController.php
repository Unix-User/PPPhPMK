<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Device;
use App\Models\Team;
use App\Models\Contract;
use App\Mail\PasswordReset;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\Item;

class UserController extends Controller
{

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $products = Product::all();
        $teams = Team::all();
        return view('users.create', compact('products', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users',
            'cep' => 'string|max:255',
            'rua' => 'string|max:255',
            'num' => 'string|max:255',
            'bairro' => 'string|max:255',
            'cidade' => 'string|max:255',
            'uf' => 'string|max:255',
            'url' => 'string|max:255',
            'product_id' => 'required',
            'api_key' => 'string|max:255',
            'expires_at' => 'string|max:255'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->cep = $request->cep;
        $user->rua = $request->rua;
        $user->num = $request->num;
        $user->etc = $request->etc;
        $user->bairro = $request->bairro;
        $user->cidade = $request->cidade;
        $user->uf = $request->uf;
        $user->url = $request->url;
        $user->api_key = $request->api_key;
        $user->expires_at = $request->expires_at;
        if(!empty($request->password)) {
            $request->validate([
                'password' => 'required|string|min:6'
            ]);
            $user->password = bcrypt($request->password);
        }
        if (Product::count() > 0) {
            $team = Product::find($request->product_id)->first()->tags;
        } else {
            if (User::count() == 0) {
                $team = 1;
            } else {
                return redirect('/products')->with('error', 'Não existem produtos cadastrados');
            }
        }
        $user->save();
        $user->teams()->sync($team);
        $user->contracts()->sync($request->product_id);

        return redirect('/users')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $products = Product::all();
        return view('users.edit', compact('user', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:255|unique:users,phone,' . $id,
            'cep' => 'max:255',
            'rua' => 'string|max:255',
            'num' => 'string|max:255',
            'etc' => 'string|max:255',
            'bairro' => 'string|max:255',
            'cidade' => 'string|max:255',
            'uf' => 'string|min:2|max:2',
            'url' => 'string|max:255',
            'api_key' => 'string|max:255',
            'expires_at' => 'string|max:255',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->cep = $request->cep;
        $user->rua = $request->rua;
        $user->num = $request->num;
        $user->etc = $request->etc;
        $user->bairro = $request->bairro;
        $user->cidade = $request->cidade;
        $user->uf = $request->uf;
        $user->url = $request->url;
        $user->api_key = $request->api_key;
        $user->expires_at = $request->expires_at;
        $user->password = bcrypt($request->password);
        if (Product::count() > 0) {
            $team = Product::find($request->product_id)->first()->tags;
        } else {
            if (User::count() == 0) {
                $team = 1;
            } else {
                return redirect('/products')->with('error', 'Não existem produtos cadastrados');
            }
        }
        $user->save();
        $user->teams()->sync($team);
        $user->contracts()->sync($request->product_id);

        return redirect('/users')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'User deleted successfully');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            return redirect('/products');
        } else {
            return redirect('/login')->with('error', 'Invalid credentials');
        }
    }

    public function recovery()
    {
        return view('users.recovery');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(60);
            $user->remember_token = $token;
            $user->save();
            Mail::to($user)->send(new PasswordReset($user, $token));
            return redirect('/login')->with('success', 'Password reset link sent to your email');
        } else {
            return redirect('/login')->with('error', 'Email not found');
        }
    }

    public function resetPassword($token)
    {
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            return view('users.renew', compact('user'));
        } else {
            return redirect('/login')->with('error', 'Invalid token');
        }
    }

    public function finish(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->remember_token = null;
            $user->save();
            return redirect('/login')->with('success', 'Password updated successfully');
        } else {
            return redirect('/login')->with('error', 'Invalid token');
        }
    }

    public function payment($id)
    {
        $user = User::find($id);
        SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
        $preference = new Preference();
        $item = new Item();
        $item->title = $user->contracts->first()->name;
        $item->quantity = 1;
        $item->unit_price = $user->contracts->first()->price;
        $preference->items = array($item);
        $preference->save();
        $payment = new Payment();
        $payment->transaction_amount = $user->contracts->first()->price;
        $payment->description = $user->contracts->first()->name;
        $payment->payment_method_id = "pix";
        $payment->payer = array(
            "email" => "wevertonsilveiralima@hotmail.com",
            "first_name" => $user->name,
            "last_name" => $user->name,
            "identification" => array(
                "type" => "CPF",
                "number" => "19119119100"
            ),
            "address" =>  array(
                "zip_code" => $user->cep,
                "street_name" => $user->rua,
                "street_number" => $user->num,
                "neighborhood" => $user->bairro,
                "city" => $user->cidade,
                "federal_unit" => $user->uf
            )
        );
        $payment->save();
        return view('users.checkout', compact('user', 'payment', 'preference'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
