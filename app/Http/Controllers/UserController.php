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
use MercadoPago\Invoice;
use MercadoPago\Plan;
use MercadoPago\Subscription;
use MercadoPago\MerchantOrder;


class UserController extends Controller
{

    public function index()
    {
        if (auth()->user()->teams->first()->id == '1') {
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        }
        return redirect('/products');
    }

    public function create()
    {
        if (!Auth::check() || auth()->user()->id == 1) {
            $products = Product::all();
            return view('users.create', compact('products'));
        } elseif (auth()->user()->teams->first()->id == 1) {
            $products = Product::where('user_id', auth()->user()->id)->get();
            return view('users.create', compact('products'));
        } else {
            return redirect('/products');
        }
    }

    public function store(Request $request)
    {
        if (!Auth::check() || (auth()->user()->teams->first()->id == ('1' || '2'))) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
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
            $user->password = bcrypt($request->password);
            $product = Product::where('id', $request->product_id)->first();
            if (!$product) {
                return redirect('/product/create')->with('error', 'Cadastre um produto primeiro!');
            }
            $team = Team::where('id', $product->user->id)->first();
            if (!$team) {
                $team = new Team;
                $team->name = $product->user->name;
                $team->save();
            }
            $user->save();
            $user->teams()->sync($team, ['created_at' => now()]);
            $user->contracts()->sync($request->product_id, ['created_at' => now()]);
            return redirect('/users')->with('success', 'User created successfully');
        }
        return redirect('/users')->with('error', 'You are not authorized to create users');
    }

    public function show($id)
    {
        $user = User::find($id);
        switch (auth()->user()->id) {
            case auth()->user()->id == '1':
                return view('users.show', compact('user'));
            case auth()->user()->id == $user->teams->first()->id:
                return view('users.show', compact('user'));
            case auth()->user()->id == $user->id:
                return view('users.show', compact('user'));
            default:
                return redirect('/users');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        /* 
         * admin team is id 1
         * test if user is admin or user is editing his own profile
         */
        switch (auth()->user()->id) {
            case auth()->user()->id == $user->id:
                $products = Product::where('user_id', auth()->user()->teams->first()->id)->get();
                return view('users.edit', compact('user', 'products'));
            case auth()->user()->id == '1':
                $products = Product::all();
                return view('users.edit', compact('user', 'products'));
            case auth()->user()->id == $user->teams->first()->id:
                $products = Product::where('user_id', auth()->user()->id)->get();
                return view('users.edit', compact('user', 'products'));
            default:
                return redirect('/users');
        }
        return redirect('/users')->with('error', 'You are not authorized to edit this user');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $id,
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
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $product = Product::where('id', $request->product_id)->first();
        if (!$product) {
            return redirect('/product/create')->with('error', 'Cadastre um produto primeiro!');
        }
        $team = Team::where('id', $product->user->id)->first();
        if (!$team) {
            $team = new Team;
            $team->name = $product->user->name;
            $team->save();
        }
        $user->save();
        $user->teams()->sync($team, ['updated_at' => now()]);
        $user->contracts()->attach($request->product_id, ['reference' => now(), 'created_at' => now()]);
        return redirect('/users')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (auth()->user()->id == $user->id || auth()->user()->id == '1' || (auth()->user()->teams->first()->id == '1' && $user->teams->first()->id == auth()->user()->id)) {
            $user->delete();
            return redirect('/users')->with('success', 'User deleted successfully');
        }
        return redirect('/users')->with('error', 'You are not authorized to delete users');
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
            return redirect('/user/' . Auth::user()->id . '/show');
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
        $item->title = $user->contracts->last()->name;
        $item->quantity = 1;
        $item->unit_price = $user->contracts->last()->price;
        $preference->items = array($item);
        $preference->external_reference = $user->contracts->last()->id;
        $preference->save();

        $payment = new Payment();
        $payment->transaction_amount = $user->contracts->last()->price;
        $payment->description = $user->contracts->last()->name;
        $payment->payment_method_id = "pix";
        $payment->external_reference = $user->contracts->last()->id;
        $payment->payer = array(
            "email" => $user->email,
            "first_name" => $user->name,
            "last_name" => $user->name,
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

        $log = file_get_contents(public_path() . '/log.txt');

        return view('users.checkout', compact('user', 'payment', 'preference', 'log'));
    }

    public function processar_pagamento(Request $request)
    {

        $log = file_get_contents(public_path() . '/log.txt');
        $log .= "\n" . date('Y-m-d H:i:s') . " - Nova requisição para processar pagamento";
        file_put_contents(public_path() . '/log2.txt', $request);

        SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
        switch($request->type) {
            case "payment":
                $payment = Payment::find_by_id($request->data->id);
                $log .= "\n" . date('Y-m-d H:i:s') . " - Pagamento encontrado";
                if ($payment->status == "approved") {
                    $log .= "\n" . "Pagamento aprovado";
                    $contract = Contract::find($payment->external_reference);
                    $contract->sync([
                        'reference' => 'paid',
                        'updated_at' => now()
                    ]);
                    $log .= "\n" . "Sistema liberado";
                } else {
                    $log .= "\n" . "Pagamento não aprovado";
                }
                break;
            case "plan":
                $plan = Plan::find_by_id($request->data->id);
                break;
            case "subscription":
                $plan = Subscription::find_by_id($request->data->id);
                break;
            case "invoice":
                $plan = Invoice::find_by_id($request->data->id);
                break;
            case "point_integration_wh":
                // $_POST contém as informações relacionadas à notificação.
                break; 
        }
        file_put_contents(public_path() . '/log.txt', $log);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
