<div class="row">
    <h2>
        <?php echo $this->view->product->product ?>
    </h2>
    <?php if ($this->auth->check()) : ?>
    <form class="pull-right" method="post"action="/user/<?php echo $this->auth->id() ?>/edit">
            <input name="cat" type="hidden" value="<?php echo $this->view->product->id ?>" />
            <input class="button small" type="submit" value="Selecionar" />
        </form>
    <?php endif; ?>
</div>
<p class="text-justify"><span class="image left"><img src="<?php echo ($product->image = '') ? '/img/' . $product->image : '/img/antena.jpg' ?>" alt="" /></span><?php echo $this->view->product->description ?></p>

