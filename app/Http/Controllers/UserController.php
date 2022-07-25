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
use App\Support\Collection;
use Illuminate\Support\Arr;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\Item;
use MercadoPago\Invoice;
use MercadoPago\Plan;
use MercadoPago\Subscription;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use Ramsey\Uuid\Uuid;
use PEAR2\Net\RouterOS;
use stdClass;

class UserController extends Controller
{

    public function index()
    {
        if (auth()->user()->teams->first()->id != 1){
            return redirect('/products')->with('error', 'página indisponivel');
        }
        $query = User::all();
        $detailed = new stdClass();
        foreach ($query as $user) {
            if ((auth()->user()->id == 1) || ($user->contracts->last()->product->user->name == auth()->user()->name)) {
                $details = $user;
                $detailed->{$user->id} = $details;
                $users =  (new Collection($detailed))->paginate(10);
            }
        }
        return view('users.index', compact('users'));
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
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        if (!Auth::check() || (auth()->user()->teams->first()->id == ('1' || '2'))) {
            $request->validate([
                'name' => 'required|alpha_dash|string|max:255',
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
            $user->contracts()->create(['user_id' => $user->id, 'product_id' => $product->id, 'reference' => Uuid::uuid4(), 'created_at' => now(), 'updated_at' => null]);
            return redirect('/users')->with('success', 'User created successfully');
        }
        return redirect('/users')->with('error', 'You are not authorized to create users');
    }

    public function show($id)
    {
        $user = User::find($id);
        if ((auth()->user()->id == '1') || (auth()->user()->name == $user->teams->first()->name) || (auth()->user()->id == $user->id)) {
            return view('users.show', compact('user'));
        }
        return redirect()->back()->with('error', 'You are not authorized');
    }

    public function edit($id)
    {
        $user = User::find($id);
        switch (auth()->user()->id) {
            case auth()->user()->id == '1':
                $products = Product::all();
                return view('users.edit', compact('user', 'products'));
            case auth()->user()->id == $user->id:
                $products = Product::where('user_id', auth()->user()->teams->first()->id)->get();
                return view('users.edit', compact('user', 'products'));
            case auth()->user()->name == $user->teams->first()->name:
                $products = Product::where('user_id', auth()->user()->id)->get();
                return view('users.edit', compact('user', 'products'));
            default:
                return redirect('/users');
        }
        return redirect('/users')->with('error', 'You are not authorized to edit this user');
    }

    public function update(Request $request, $id)
    {
        if ((Auth::check()) && (Auth::user()->id != 1) && (Auth::user()->id != $id)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30 < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $request->validate([
            'name' => 'required|alpha_dash|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:255|unique:users,phone:BR,' . $id,
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
        $team = Team::where('name', $product->user->name)->first();
        if($product->id == 1){
            $team = Team::find(1);
        }
        if (!$team) {
            $team = new Team;
            $team->name = $product->user->name;
            $team->save();
        }
        $user->save();
        $user->teams()->sync($team, ['updated_at' => now()]);
        if ($user->contracts->last()->product_id != $product->id) {
            $user->contracts()->create(['user_id' => $user->id, 'product_id' => $product->id, 'reference' => Uuid::uuid4(), 'created_at' => now()]);
        }
        return redirect('/users')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $user = User::find($id);
        if (auth()->user()->id == $user->id || auth()->user()->id == '1' || (auth()->user()->teams->first()->id == '1' && $user->teams->first()->name == auth()->user()->name)) {
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
            if (Auth::user()->id == 1) {
                return redirect('/user/' . Auth::user()->id . '/show');
            }
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Seja bem vindo, sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            } else {
                return redirect('/user/' . Auth::user()->id . '/show')->with('success', "Seja bem vindo, sua fatura vence em " . $d2 + 30  . " dias");
            }
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
        if ($user->contracts->last()->updated_at > now()->subMinutes(2)) {
            return redirect()->back()->with('error', 'Seu contrato ainda está ativo volte daqui ' . now()->subMinutes(2)->diffForHumans());
        }
        $token = env('MP_ACCESS_TOKEN');
        $key = env('MP_PUB_KEY');
        if ($user->teams->last()->mode == 'dev') {
            $token = env('Test_MP_ACCESS_TOKEN');
            $key = env('Test_MP_PUB_KEY');
        }
        SDK::setAccessToken($token);
        $preference = new Preference();
        $item = new Item();
        $item->title = $user->contracts->last()->product->name;
        $item->quantity = 1;
        $item->unit_price = $user->contracts->last()->product->price;
        $preference->items = array($item);
        $preference->external_reference = $user->contracts->last()->reference;
        $preference->notification_url = env('APP_URL') . '/api/processar_pagamento?source_news=webhooks';
        $preference->back_urls = (object) [
            "success" => env('APP_URL') . "/user/" . $user->id . "/show",
            "failure" => env('APP_URL') . "/user/" . $user->id . "/show",
            "pending" => env('APP_URL') . "/user/" . $user->id . "/show"
        ];
        $preference->auto_return = "approved";
        $preference->save();

        $payment = new Payment();
        $payment->transaction_amount = $user->contracts->last()->product->price;
        $payment->description = $user->contracts->last()->product->name;
        $payment->payment_method_id = "pix";
        $payment->external_reference = $user->contracts->last()->reference;
        $payment->notification_url = env('APP_URL') . '/api/processar_pagamento?source_news=webhooks';
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

        return view('users.checkout', compact('user', 'payment', 'preference', 'key'));
    }

    public function processar_pagamento(Request $request)
    {
        $input = $request->all();
        $token = env('MP_ACCESS_TOKEN');
        if (User::find(1)->teams->first()->mode == 'dev') {
            $token = env('Test_MP_ACCESS_TOKEN');
        }
        $log = 'nova requisição:' . $input["data"]["id"];
        SDK::setAccessToken($token);
        switch ($input["type"]) {
            case "payment":
                $payment = Payment::find_by_id($input["data"]["id"]);
                if ($payment->status == "approved") {
                    $contract = Contract::where('reference', $payment->external_reference);
                    $contract->update(['updated_at' => $payment->date_approved]);
                }
                break;
            case "plan":
                $plan = Plan::find_by_id($input["data"]["id"]);
                break;
            case "subscription":
                $plan = Subscription::find_by_id($input["data"]["id"]);
                break;
            case "invoice":
                $plan = Invoice::find_by_id($input["data"]["id"]);
                break;
            case "point_integration_wh":
                // $_POST contém as informações relacionadas à notificação.
                break;
        }
        $log .= "\n" . $request->all() . "\n";
        $log .= file_get_contents(public_path() . '/log.txt');
        file_put_contents(public_path() . '/log.txt', $log);
        return response()->json(['status' => 'created'], 201);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function system()
    {
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30 < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $team = Team::where('name', auth()->user()->name)->first();
        if (!$team) {
            $team = new Team;
            $team->name = auth()->user()->name;
            $team->save();
        }
        $log = file_get_contents(public_path() . '/log.txt');
        $users = User::all();
        $teams = Team::all();
        $products = Product::all();
        $contracts = Contract::all();
        return view('users.system', compact('users', 'products', 'contracts', 'log', 'teams'));
    }

    public function config(Request $request, $id)
    {
        $user = User::find($id);
        $team = Team::where('name', $user->name)->first();
        if (!$team) {
            $team = new Team;
            $team->name = $user->name;
            $team->save();
        }
        $password = $team->password;
        if ($request->password) {
            $request->validate([
                'password' => ['required', 'string', 'min:2'],
            ]);
            $password = $request->password;
        }
        $team->password = $password;
        $team->mode = $request->mercado_pago;
        $team->save();
        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso - ' . $team->mode . '-' . $request->mercado_pago);
    }

    public function disconnect($name)
    {
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30 < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $client = new RouterOS\Client($device->ip, $device->user, $device->password);
            $printRequest = new RouterOS\Request('/ppp active print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $name));
            $id = $client->sendSync($printRequest)->getProperty('.id');

            $request = new RouterOS\Request('/ppp active remove');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);
        }
        return redirect()->back()->with('success', 'Desconectado com sucesso');
    }

    public function disable($name)
    {
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $client = new RouterOS\Client($device->ip, $device->user, $device->password);
            $printRequest = new RouterOS\Request('/ppp secret print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $name));
            $id = $client->sendSync($printRequest)->getProperty('.id');

            $request = new RouterOS\Request('/ppp secret disable');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);
        }
        return redirect()->back()->with('success', 'Desativado com sucesso');
    }

    public function enable($name)
    {
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $client = new RouterOS\Client($device->ip, $device->user, $device->password);
            $printRequest = new RouterOS\Request('/ppp secret print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $name));
            $id = $client->sendSync($printRequest)->getProperty('.id');

            $request = new RouterOS\Request('/ppp secret enable');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);
        }
        return redirect()->back()->with('success', 'Ativado com sucesso');
    }

    public function remove($name)
    {
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $client = new RouterOS\Client($device->ip, $device->user, $device->password);
            $printRequest = new RouterOS\Request('/ppp secret print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $name));
            $id = $client->sendSync($printRequest)->getProperty('.id');

            $request = new RouterOS\Request('/ppp secret remove');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);
        }
        return redirect()->back()->with('success', 'Removido com sucesso');
    }
}
