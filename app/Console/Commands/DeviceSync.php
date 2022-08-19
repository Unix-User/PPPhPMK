<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use App\Models\User;
use PEAR2\Net\RouterOS;

class DeviceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza dispositivos mikrotik conectados ao servidor';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $devices = Device::all();
        foreach ($devices as $device) {
            $owner = User::find($device->user_id);
            $script = "";
            $script .= '/ppp secret remove [find where comment="Usuario criado pelo sistema - ' . $owner->name . '"];
                /ppp profile remove [find where comment="Perfil criado pelo sistema - ' . $owner->name . '"];';
            $c1 = strtotime($owner->contracts->last()->updated_at);
            $c2 = ceil(($c1 - time()) / 60 / 60 / 24);
            $client = new RouterOS\Client($device->ip, $device->user, $device->password);
            if (($c2 + 30  < 1) || ($owner->teams()->first()->name != 'Administrador')) {
                $info = "Processo de sincronizacao abortado para " . $owner->name . ", verifique o painel de controle no site.";
                $request = new RouterOS\Request('/log info');
                $request->setArgument('message', $info);
                $client->sendSync($request);

                $request = new RouterOS\Request('/system note set');
                $request->setArgument('show-at-login', 'yes');
                $request->setArgument('note', $info);
                $client->sendSync($request);
            } else {
                foreach (User::all() as $user) {
                    if ($user->teams->first()->name == $owner->name) {
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
                            if ($d2 + 45  < 1) {
                                $profile = 'bloqueio';
                            }
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
                            $request->setArgument('comment', 'Perfil criado pelo sistema - ' . $owner->name);
                            $client->sendSync($request);
                            $profile = $user->name;
                        }

                        $request = new RouterOS\Request('/ppp secret add');
                        $request->setArgument('name', $user->name);
                        $request->setArgument('password', $owner->teams()->first()->password);
                        $request->setArgument('service', 'pppoe');
                        $request->setArgument('profile', $profile);
                        $request->setArgument('comment', 'Usuario criado pelo sistema - ' . $owner->name);
                        $client->sendSync($request);
                    }
                }
                $info = 'Processo de sincronizacao para ' . $owner->name . ' finalizado com sucesso.';
                $request = new RouterOS\Request('/log info');
                $request->setArgument('message', $info);
                $client->sendSync($request);
            }

            $printRequest = new RouterOS\Request('/system scheduler print');
            $printRequest->setArgument('.proplist', '.id');
            $printRequest->setQuery(RouterOS\Query::where('name', $owner->name . '-sync'));
            $id = $client->sendSync($printRequest)->getProperty('.id');

            $request = new RouterOS\Request('/system scheduler remove');
            $request->setArgument('numbers', $id);
            $client->sendSync($request);
            $util = new RouterOS\Util($client);
            $util->setMenu('/system scheduler')->add(
                array(
                    'name' => $owner->name . '-sync',
                    'interval' => '1d',
                    'start-time' => '4:00:00',
                    'on-event' => RouterOS\Script::prepare($script)
                )
            );
        }
    }
}
