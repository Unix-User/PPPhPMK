<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Support\Collection;
use App\Models\User;
use PEAR2\Net\RouterOS;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use stdClass;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class DeviceController extends Controller
{

    public function index()
    {
        $devices = Device::all();
        $detailed = new stdClass();
        $items = [];
        foreach ($devices as $device) {
            if (($device->user_id == auth()->user()->id) || (auth()->user()->id == 1)) {
                try {
                    $client = new RouterOS\Client($device->ip, $device->user, $device->password);
                    $response = $client->sendSync(new RouterOS\Request('/system resource print'));
                    $items[$device->id] = [
                        'id' => $device->id,
                        'name' => $device->name,
                        'ip' => $device->ip,
                        'user' => $device->user,
                        'password' => $device->password,
                        'uptime' => $response->getProperty('uptime'),
                        'cpu_load' => $response->getProperty('cpu-load'),
                        'version' => $response->getProperty('version'),
                        'board_name' => $response->getProperty('board-name')
                    ];
                } catch (Exception $e) {
                    $items[$device->id] = [
                        'id' => $device->id,
                        'name' => $device->name,
                        'ip' => $device->ip,
                        'user' => $device->user,
                        'password' => $device->password,
                        'uptime' => 'off-line',
                        'cpu_load' => '---',
                        'version' => '---',
                        'board_name' => '---'
                    ];
                }
                
            }
        }
        $detailed =  (new Collection($items))->paginate(3);
        return view('devices.index', compact('detailed'));
    }

    public function connect($id)
    {
        $device = Device::find($id);
        if ($device->user_id == auth()->user()->id) {
            $device->ikev2 = Str::random(60);
            $device->save();
            return view('devices.connect', compact('device'));
        }
        return back()->with('error', 'Dispositivo indisponivel!');
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha_dash',
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
        $device->user_id = auth()->user()->id;
        $device->save();
        return redirect('/devices')->with('success', 'Dispositivo criado com sucesso!');
    }

    public function show($id)
    {
        $device = Device::find($id);
        $client = new RouterOS\Client($device->ip, $device->user, $device->password);
        $users = User::all();
        $detailed = new stdClass();
        foreach ($users as $user) {
            if ((auth()->user()->id == 1) || ($user->contracts->last()->product->user->name == auth()->user()->name)) {
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

                $detailed->{$user->id} = $details;
                $newUsers =  (new Collection($detailed))->paginate(10);
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
            'name' => 'required|alpha_dash',
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
        if ((Auth::check()) && (Auth::user()->id != 1)) {
            $d1 = strtotime(Auth::user()->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                return redirect('/user/' . Auth::user()->id . '/show')->with('error', "Sua fatura venceu, efetue o pagamento para desbloquear o sistema");
            }
        }
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

            $d1 = strtotime($user->contracts->last()->updated_at);
            $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
            if ($d2 + 30  < 1) {
                $profile = 'notificar';
            } else {
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
                $request->setArgument('comment', 'Perfil criado pelo sistema - ' . User::find($device->user_id)->teams()->first()->name);
                $client->sendSync($request);
                $profile = $user->name;
            }
            $request = new RouterOS\Request('/ppp secret add');
            $request->setArgument('name', $user->name);
            $request->setArgument('password', User::find($device->user_id)->teams()->first()->password);
            $request->setArgument('service', 'pppoe');
            $request->setArgument('profile', $profile);
            $request->setArgument('comment', 'Usuario criado pelo sistema - ' . auth()->user()->name);
            $client->sendSync($request);
        }
        return redirect()->back()->with('success', 'Sistema sincronizado com sucesso');
    }

    public function register($token)
    {
        if ($token == null) {
            return;
        }
        $device = Device::where('ikev2', $token)->first();
        $device->ikev2 = Str::random(60);
        $device->save();
        $script = null;
        $ports = array(8728, 8729);
        foreach ($ports as $port) {
            $connection = @fsockopen($device->ip, $port, $errno, $errstr, 1);
            if (!is_resource($connection)) {
                $config = "conn $device->name" . PHP_EOL . "  rightid=@$device->name" . PHP_EOL . "  rightaddresspool=" . $device->ip . "-" . $device->ip . PHP_EOL . "  also=ikev2-cp" . PHP_EOL;
                Storage::disk('local')->put($device->name . '.conf', $config);
                $process = new Process(['sudo', '-u', 'www-data', 'sudo', 'systemctl', 'restart', 'ipsec.service',]);
                $process->run();
                $script = "/tool fetch url=https://" . $_SERVER['HTTP_HOST'] . "/api/cert/" . $device->ikev2 . " dst-path=" . $device->name . '.p12; :delay 4000ms;' . PHP_EOL;
                $script .= '/certificate import file-name=' . $device->name . '.p12 passphrase="";' . PHP_EOL;
                $script .= '/certificate import file-name=' . $device->name . '.p12 passphrase="";' . PHP_EOL;
                $script .= "/ip ipsec mode-config add name=ike2-rw responder=no;" . PHP_EOL;
                $script .= "/ip ipsec policy group add name=ike2-rw;" . PHP_EOL;
                $script .= "/ip ipsec profile add name=ike2-rw;" . PHP_EOL;
                $script .= "/ip ipsec peer add address=srv." . $_SERVER['HTTP_HOST'] . " exchange-mode=ike2 name=ike2-rw-client profile=ike2-rw;" . PHP_EOL;
                $script .= "/ip ipsec proposal add name=ike2-rw pfs-group=none;" . PHP_EOL;
                $script .= "/ip ipsec identity add auth-method=digital-signature certificate=$device->name.p12_1 generate-policy=port-strict mode-config=ike2-rw peer=ike2-rw-client policy-template-group=ike2-rw;" . PHP_EOL;
                $script .= "/ip ipsec policy add group=ike2-rw proposal=ike2-rw template=yes" . PHP_EOL;
            } else {
                fclose($connection);
            }
        }
        return $script;
    }

    public function cert($token)
    {
        if ($token == null) {
            return;
        }
        $device = Device::where('ikev2', $token)->first();
        $device->ikev2 = null;
        $device->save();

        $process = new Process(['sudo', '-u', 'www-data', 'sudo', '/usr/bin/ikev2.sh', '--addclient', $device->name]);
        $process->run();


        if (!$process->isSuccessful()) {
            $process = new Process(['sudo', '-u', 'www-data', 'sudo', '/usr/bin/ikev2.sh', '--exportclient', $device->name]);
            $process->run();
            $fileName = $device->name . '.p12';
            //throw new ProcessFailedException($process);
        }
        $fileName = $device->name . '.p12';

        if (!$fileName || !Storage::disk('cert')->exists($fileName)) {
            abort(404);
        }
        return response()->stream(function () use ($fileName) {
            $stream = Storage::disk('cert')->readStream($fileName);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Disposition'   => 'attachment; filename="' . basename($fileName) . '"',
        ]);
    }
}
