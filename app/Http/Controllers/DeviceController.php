<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use PEAR2\Net\RouterOS;
use stdClass;

class DeviceController extends Controller
{

    public function index()
    {
        $devices = Device::all();
        // create a new object in detailed variable
        $detailed = new stdClass();
        foreach ($devices as $device) {
            $client = new RouterOS\Client($device->ip, $device->user, $device->password);
            $response = $client->sendSync(new RouterOS\Request('/system resource print'));
            // create a new device object
            $newDevice = new stdClass();
            $newDevice->id = $device->id;
            $newDevice->name = $device->name;
            $newDevice->ip = $device->ip;
            $newDevice->user = $device->user;
            $newDevice->password = $device->password;
            $newDevice->uptime = $response->getProperty('uptime');
            $newDevice->cpu_load = $response->getProperty('cpu-load');
            $newDevice->version = $response->getProperty('version');
            $newDevice->board_name = $response->getProperty('board-name');
            $detailed->{$device->id} = $newDevice;
        }
        return view('devices.index', compact('detailed'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ip' => 'required',
            'user' => 'required',
            'password' => 'required',
        ]);

        if (!$request->ikev2) {
            $request->ikev2 = false;
        }

        $device = new Device();
        $device->name = $request->name;
        $device->ip = $request->ip;
        $device->user = $request->user;
        $device->password = $request->password;
        $device->ikev2 = $request->ikev2;
        $device->user_id = auth()->user()->id;
        $device->save();
        return redirect('/devices')->with('success', 'Dispositivo criado com sucesso!');
    }

    public function show($id)
    {
        $device = Device::find($id);
        $client = new RouterOS\Client($device->ip, $device->user, $device->password);
        $users = User::all();
        $newUsers = new stdClass();
        foreach ($users as $user) {
            if ($user->teams->first()->name == $device->user) {
                $query = RouterOS\Query::where('name', $user->name);
                $details = $user;

                $requestData = new RouterOS\Request('/ppp secret print');
                $requestData->setQuery($query);
                $data = $client->sendSync($requestData);
                $details->status = $data->getProperty('disabled');
                $details->profile = $data->getProperty('profile');

                $requestStatus = new RouterOS\Request('/ppp active print');
                $requestStatus->setQuery($query);
                $status = $client->sendSync($requestStatus);
                $details->mac = $status->getProperty('caller-id');
                $details->address = $status->getProperty('address');
                $details->uptime = $status->getProperty('uptime');

                $newUsers->{$user->id} = $details;
            }
        }
        return view('devices.show', compact('device', 'newUsers'));
    }

    public function edit($id)
    {
        $device = Device::find($id);
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ip' => 'required',
            'name' => 'required',
            'user' => 'required',
            'password' => 'required',
        ]);

        if (!$request->ikev2) {
            $request->ikev2 = false;
        }

        $device = Device::find($id);
        $device->name = $request->name;
        $device->ip = $request->ip;
        $device->user = $request->user;
        $device->password = $request->password;
        $device->ikev2 = $request->ikev2;
        $device->user_id = auth()->user()->id;
        $device->save();

        return redirect('/devices')->with('success', 'Dispositivo atualizado com sucesso!');
    }

    public function delete($id)
    {
        $device = Device::find($id);
        $device->delete();

        return redirect('/devices')->with('success', 'Dispositivo excluído com sucesso!');
    }

    public function sync($id)
    {
        $device = Device::find($id);
        $client = new RouterOS\Client($device->ip, $device->user, $device->password);
        foreach (User::all() as $user) {
            $request = new RouterOS\Request('/ppp secret remove');
            $printRequest = new RouterOS\Request('/ppp secret print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $user->name));
            $id = $client->sendSync($printRequest)->getProperty('.id');

            $request = new RouterOS\Request('/ppp secret remove');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);

            $profilePrintRequest = new RouterOS\Request('/ppp profile print');
            $profilePrintRequest->setArgument('.proplist', '.id');
            $profilePrintRequest->setQuery(RouterOS\Query::where('name', $user->name));
            $id = $client->sendSync($profilePrintRequest)->getProperty('.id');

            $request = new RouterOS\Request('/ppp profile remove');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);

            $request = new RouterOS\Request('/ppp profile add');
            $request->setArgument('name', $user->name);
            if ($user->contracts->last()->product->tags != null) {
                $request->setArgument('rate-limit', $user->contracts->last()->product->tags / 2 . 'm/' . $user->contracts->last()->product->tags . 'm');
            }
            $request->setArgument('comment', 'Perfil criado pelo sistema' . auth()->user()->name);
            $client->sendSync($request);

            $request = new RouterOS\Request('/ppp secret add');
            $request->setArgument('name', $user->name);
            $request->setArgument('password', User::find($device->user_id)->teams()->first()->password);
            $request->setArgument('service', 'pppoe');
            $request->setArgument('profile', $user->name);
            $request->setArgument('comment', 'Usuario criado pelo sistema - ' . auth()->user()->name);
            $client->sendSync($request);
        }
        return redirect()->back()->with('success', 'Sistema sincronizado com sucesso');
    }
}
