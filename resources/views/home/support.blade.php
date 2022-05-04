<?php $this->renderView('alerts/_success'); ?>
<?php $this->renderView('alerts/_errors'); ?>
<header class="major">
    <h2><?php echo $this->getPageTitle(); ?></h2>
    <p>Nessa página voce solicita e gerencia os tickets de suporte tecnico.</p>
</header>
<section>
    <div class="table-wrapper">Tickets: <br />
        <table class="alt">
            <thead>
                <tr>
                    <th>id</th>
                    <th>usuário</th>
                    <th class="hidden-xs">descrição</th>
                    <th class="hidden-xs">data</th>
                    <th class="text-right"><a href="/user/create" class="icon fa-plus special"></a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->view->users as $user): ?>
                    <?php if ($user->owner->id == $this->auth->id()): ?>
                    <tr>
                        <th><a class="clean" href="/user/<?php echo $user->id; ?>/show" ><?php echo $user->id; ?></a></th>
                        <th><a class="clean" href="/user/<?php echo $user->id; ?>/show" ><?php echo $user->name; ?></a></th>
                        <th class="hidden-xs"><?php echo $user->email; ?></th>
                        <th class="hidden-xs"><?php echo $user->owner->name; ?></th>
                        <th class="hidden-xs">
                            <?php foreach ($user->category as $cat): ?>
                                <?php echo $cat->product; ?>
                                <?php echo "R$" . number_format($cat->value, 2, '.', ''); ?>
                            <?php endforeach; ?>
                        </th>
                        <th class="text-right">
                            <?php if ($this->auth->check() && $this->auth->admin()) : ?>
                                <a href="/user/<?php echo $user->id ?>/delete" class="icon fa-trash " onclick="return confirm('Deletar esse cadastro no sistema? Não sera mais possivel fazer login com esse usuário e todos os dados serão perdidos!')"></a>
                            <?php else: ?>
                                <span class="icon fa-trash "></span>
                            <?php endif; ?>
                        </th>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>