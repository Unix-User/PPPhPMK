<header class="major">
    <h2><?php echo $this->getPageTitle(); ?></h2>
    <p>Aqui voce obtem informções detalhadas sobre produtos e serviços</p>

</header>
<?php $this->renderView('alerts/_success'); ?>
<?php $this->renderView('alerts/_errors'); ?>
<div> 
    <?php if ($this->auth->check() && $this->auth->admin()) : ?>
        <div class="panel-body row 50% uniform">
            <a href="/product/create" class="icon fa-plus special pull-right"></a>
        </div>&nbsp
    <?php endif; ?>
    <div class="card-columns">
        <?php foreach ($this->view->products as $product): ?>
            <div class="card bg-custom"><a class="clean" href="/product/<?php echo $product->id; ?>/show" >
                    <img class="card-img-top" src="/img/antena.jpg" alt="Imagem de capa do card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product->product; ?></h5>
                        <p class="card-text"><?php echo $product->description; ?></p>
                        <p class="card-text"><small class="text-muted"><?php echo " R$" . $product->value; ?></small></p>
                        <?php if ($this->auth->check() && $this->auth->admin()) : ?>
                            <span class="6u 6u$(medium) 12u$(xsmall)">
                                <span class="pull-right">
                                    <a href="/product/<?php echo $product->id ?>/edit" class="icon fa-edit">
                                    </a>
                                    <a href="/product/<?php echo $product->id ?>/delete" class="icon special fa-trash" onclick="return confirm('Deletar esse intem?')">
                                    </a>
                                </span>
                            </span>
                        <?php endif; ?>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>