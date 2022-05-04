<nav id="nav">
    <ul>
        <li><a href="/products">Produtos</a></li>
        <?php if ($this->auth->check() && $this->auth->admin()) : ?>
            <li><a href="/users">Pessoas</a></li>
            <li><a href="/system">Sistema</a></li>
        <?php endif; ?>
        <?php if ($this->auth->check()) : ?>
            <li><a href="/support">Suporte</a></li>
            <li class="dropdown">
                <a href="#" class="text-capitalize"><?php echo $this->auth->name() ?></a>
                <ul>
                    <li><a href="/client ">Inicio</a></li>
                    <li><a href="/user/<?php echo $this->auth->id() ?>/show ">Perfil</a></li>
                    <li><a href="http://srv.unixlocal.ml/devices">Dispositivos</a></li>
                    <li><a href="/logout">Sair</a></li>
                </ul>
            </li>
        <?php else : ?>
            <li><a href="/contact">Contato</a></li>
            <li><a class="button" href="/login">Entrar</a></li>
            <li><a class="button special" href="/user/create">Registre-se</a></li>
            <?php endif; ?>
    </ul>
</nav>