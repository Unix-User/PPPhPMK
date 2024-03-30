<?php

namespace App\Services;

use phpseclib3\Net\SSH2;
use phpseclib3\Net\SFTP;
use phpseclib3\Crypt\PublicKeyLoader;

class SSHService
{
    protected $ssh;
    protected $sftp;

    public function __construct()
    {
        $this->ssh = new SSH2(env('SSH_HOST'));
        $this->sftp = new SFTP(env('SSH_HOST'));
        $key = PublicKeyLoader::load(file_get_contents(env('SSH_PRIVATE_KEY_PATH')));

        if (!$this->ssh->login(env('SSH_USERNAME'), $key) || !$this->sftp->login(env('SSH_USERNAME'), $key)) {
            throw new \Exception('Login failed');
        }
    }

    public function executeCommand($command)
    {
        return $this->ssh->exec($command);
    }

    public function copyFile($remoteFilePath, $localFilePath)
    {
        if (!$this->sftp->get($remoteFilePath, $localFilePath)) {
            throw new \Exception("File copy failed");
        }
    }
    public function disconnect()
    {
        $this->ssh->disconnect();
        $this->sftp->disconnect();
    }
}
