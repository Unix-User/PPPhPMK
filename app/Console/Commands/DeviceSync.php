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
                $request->setArgument('comment', 'Usuario criado pelo sistema - ' . User::find($device->user_id)->teams()->first()->name);
                $client->sendSync($request);
            }
        }
        $this->info('Processo de sincronização finalizado com sucesso.');
    }
}
