<div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="connected-tab" data-bs-toggle="tab" data-bs-target="#connected" type="button" role="tab" aria-controls="connected" aria-selected="true">Ativos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Registrados</button>
        </li>
        <!--<li class="nav-item" role="presentation">
            <button class="nav-link" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab" aria-controls="config" aria-selected="false">Configurações</button>
        </li>-->
    </ul>
    <br />
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="connected" role="tabpanel" aria-labelledby="connected-tab">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if (isset($this->view->active)) : ?>
                    <?php foreach ($this->view->active as $user) : ?>
                        <?php  // set name, profile
                        $name = $user->getProperty('name');
                        $uptime = $user->getProperty('uptime');
                        $address = $user->getProperty('address'); ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h3 class="h3"><i class="bi-person"></i><?php echo $name; ?></h3>
                                    <p class="card-text text-justify">Tempo de Conexão: <?php echo $uptime; ?>
                                        <?php //get status for this client
                                        $this->util->setMenu('/interface');
                                        $status = $this->util->getAll();
                                        foreach ($status as $user) {
                                            if ($user->getProperty('name') == '<pppoe-' . $name . '>') {
                                                //the next values are prompted in MiB, we will conver to MB and GB to keep user friendly readable || 1 MiB = 1.048576 MB
                                                $precision = 2;
                                                $units = array('B', 'KB', 'MB', 'GB', 'TB');
                                                $rx = max($user->getProperty('rx-byte'), 0);
                                                $pow = floor(($rx ? log($rx) : 0) / log(1024));
                                                $pow = min($pow, count($units) - 1);
                                                $rx /= pow(1024, $pow);
                                                $rx = round($rx, $precision) . ' ' . $units[$pow];
                                                $tx = max($user->getProperty('tx-byte'), 0);
                                                $pow = floor(($tx ? log($tx) : 0) / log(1024));
                                                $pow = min($pow, count($units) - 1);
                                                $tx /= pow(1024, $pow);
                                                $tx = round($tx, $precision) . ' ' . $units[$pow];
                                            }
                                        }
                                        ?>
                                        <br />Dados recebidos: <?php echo $rx; ?>
                                        <br />Dados transferidos: <?php echo $tx; ?>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted float-end">
                                        <a href="<?php echo 'http://' . $address; ?>" target="_blank">
                                            <button class="btn btn-primary btn-xs" type="button">
                                                <i class="bi-router"></i> <?php echo $address; ?>
                                            </button>
                                        </a>
                                        <a href="/user/<?php echo $name; ?>/disconnect">
                                            <button class="btn btn-warning btn-xs" type="button" onclick="return confirm('Deseja desconectar esse usuário?')">
                                                <i class="bi-wifi-off"></i>
                                            </button>
                                        </a>
                                        <a href="/user/<?php echo  $name; ?>/disable">
                                            <button class="btn btn-secondary btn-xs" type="button">
                                                <i class="bi-person-dash"></i>
                                            </button>
                                        </a>
                                        <a href="/user/<?php echo $name; ?>/remove">
                                            <button class="btn btn-danger btn-xs" type="button" onclick="return confirm('Deseja apagar esse usuário?')">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </a>
                                    </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if (isset($this->view->users)) : ?>
                    <?php foreach ($this->view->users as $user) : ?>
                        <?php  // get name, profile and status
                        $name = $user->getProperty('name');
                        $profile = $user->getProperty('profile'); ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h3 class="h3"><i class="bi-person"></i><?php echo $name; ?></h3>
                                    <p class="card-text text-justify">Perfil de Conexão: <?php echo $profile; ?></p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted float-end">
                                        <a href="/user/<?php echo $name; ?>/disconnect">
                                            <button class="btn btn-warning btn-xs" type="button" onclick="return confirm('Deseja desconectar esse usuário?')">
                                                <i class="bi-wifi-off"></i>
                                            </button>
                                        </a>
                                        <a href="/user/<?php echo  $name; ?>/disable">
                                            <button class="btn btn-secondary btn-xs" type="button">
                                                <i class="bi-person-dash"></i>
                                            </button>
                                        </a>
                                        <a href="/user/<?php echo $name; ?>/remove">
                                            <button class="btn btn-danger btn-xs" type="button" onclick="return confirm('Deseja apagar esse usuário?')">
                                                <i class="bi-trash"></i>
                                            </button>
                                        </a>
                                    </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="config" role="tabpanel" aria-labelledby="config-tab">...</div>
    </div>
</div>