<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    //

    public function index()
    {
        // display a view with all of the devices
        $devices = Device::all();
        return view('devices.index', compact('devices'));
        
    }

    public function create()
    {
        // display a form to create a new device
        return view('devices.create');
    }

    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'ip' => 'required',
            'user' => 'required',
            'password' => 'required',
        ]);

        // if ikev2 is not checked, set it to false
        if (!$request->ikev2) {
            $request->ikev2 = false;
        }

        // create a new device
        $device = new Device();
        $device->name = $request->name;
        $device->ip = $request->ip;
        $device->user = $request->user;
        $device->password = $request->password;
        $device->ikev2 = $request->ikev2;
        // device user_id is the id of the user that created the device
        $device->user_id = auth()->user()->id;
        $device->save();

        // redirect to the device index
        return redirect('/devices')->with('success', 'Dispositivo criado com sucesso!');
    }

    public function show($id)
    {
        // display a view with the specified device
        return view('devices.show');
    }

    public function edit($id)
    {
        // display a form to edit the specified device
        $device = Device::find($id);
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'ip' => 'required',
            'name' => 'required',
            'user' => 'required',
            'password' => 'required',
        ]);

        // if ikev2 is not checked, set it to false
        if (!$request->ikev2) {
            $request->ikev2 = false;
        }

        // update the specified device
        $device = Device::find($id);
        $device->name = $request->name;
        $device->ip = $request->ip;
        $device->user = $request->user;
        $device->password = $request->password;
        $device->ikev2 = $request->ikev2;
        // device user_id is the id of the user that created the device
        $device->user_id = auth()->user()->id;
        $device->save();

        // redirect to the device index
        return redirect('/devices')->with('success', 'Dispositivo atualizado com sucesso!');
    }

    public function delete($id)
    {
        // delete the specified device
        $device = Device::find($id);
        $device->delete();

        // redirect to the device index
        return redirect('/devices')->with('success', 'Dispositivo excluído com sucesso!');
    }
}
