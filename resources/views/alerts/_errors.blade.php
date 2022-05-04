<?php if ($this->errors): ?>
<div style="width: 100%; position: relative; background-color: #272833; border-color: #843534" class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
        <?php foreach ($this->errors as $msg): ?>
            <p><i class="icon fa-exclamation-triangle"></i> <?php echo $msg; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>