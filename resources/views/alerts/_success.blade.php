<?php if ($this->success): ?>
<div style="width: 100%; position: relative; background-color: #272833; border-color: #255625" class="alert alert-success alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
        <?php foreach ($this->success as $msg): ?>
            <p><i class="icon fa-check"></i> <?php echo $msg; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>