<header class="major">
    <h2><?php echo $this->getPageTitle(); ?></h2>
</header>
<div>
    <form action="/product/store" method="post" accept-charset="utf-8">
        <div class="row">
            <div class="form-group <?php echo($this->errors['product']) ? 'has-error ' : ' '; ?>8u 6u(medium) 12u$(xsmall)">
                <label for="title" class="control-label">Produto</label>
                <input type="text" name="product" class="form-control" value="<?php echo (isset($this->inputs['product'])) ? $this->inputs['product'] : $this->view->product->product; ?>"/>
                <?php if ($this->errors['product']): ?>
                    <span class="help-block"><?php echo $this->errors['product'] ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group <?php echo($this->errors['rate']) ? 'has-error ' : ' '; ?>2u 6u(medium) 12u$(xsmall)">
                <label for="title">Rate limit</label>
                <input type="text" name="rate" class="form-control" value="<?php echo (isset($this->inputs['rate'])) ? $this->inputs['rate'] : $this->view->product->rate; ?>" />
                <?php if ($this->errors['rate']): ?><span class="help-block"><?php echo $this->errors['rate'] ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group <?php echo($this->errors['value']) ? 'has-error ' : ' '; ?>2u 6u(medium) 12u$(xsmall)">
                <label for="title">Valor</label>
                <input type="text" name="value" class="form-control" value="<?php echo (isset($this->inputs['value'])) ? $this->inputs['value'] : $this->view->product->value; ?>" />
                <?php if ($this->errors['value']): ?>
                    <span class="help-block"><?php echo $this->errors['value'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group <?php echo($this->errors['description']) ? 'has-error ' : ' '; ?>10u 6u(medium) 12u$(xsmall)">
                <label for="title" class="control-label">Descrição</label>
                <textarea type="text" name="description"><?php echo (isset($this->inputs['description'])) ? $this->inputs['description'] : $this->view->product->description; ?></textarea>
                <?php if ($this->errors['description']): ?><span class="help-block"><?php echo $this->errors['description'] ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group pull-right <?php echo ($this->errors['image']) ? 'has-error ' : ' ' ?>2u 6u(medium) 12u$(xsmall)">
                <label for="title">Enviar imagem</label>
                <a href="#" class="btn clean" onclick="document.getElementById('fileInput').click();"><span class="icon alt major fa-upload"></span></a>
                <input id="fileInput" type="file" name="image" style="display: none;" />
                <?php if ($this->errors['image']): ?>
                    <span class="help-block"><?php echo $this->errors['image'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <a href="/products" class="button special small">Cancelar</a>
        <button type="submit" class="button small">Salvar</button>
    </form>
    <form id="formImage" style="display:none">
      <input type="file" id="fileUpload" name="fileUpload[]" multiple onchange="saveImages()">
   </form>

   <div id="btnFake" style="background:#CCC; width:100px; height:100px; cursor:pointer;"></div>

   <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <script src="//malsup.github.io/jquery.form.js"></script>

   <script>
      document.getElementById('btnFake').addEventListener('click', function(){
         document.getElementById('fileUpload').click();
      });

      function saveImages()
      {
         $('#formImage').ajaxSubmit({
            url  : 'multiple-upload-ajax.php',
            type : 'POST'
         });
      }
   </script>
</div>
