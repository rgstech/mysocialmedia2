<?= $this->extend('/layouts/main_layout') ?>

<?= $this->section('content') ?>

<h3>Editar <?=  isset($post) ?  "Post" : "Commentário" ?></h3>

 
 <?php
  if (isset($post)) {
       echo form_open('post/save',  ['class' => 'pull_right']); 
  }  else {
       echo form_open('comment/save',  ['class' => 'pull_right']);
  } ?>

    <?php  if (isset($post)) { ?>

          <input type="hidden" name="post_id" value="<?php echo $post['pst_pk_id'] ?>" />
          <input type="hidden" name="user_id" value="<?php echo $post['pst_fk_usu']  ?>" />

    <?php } else { ?>

          <input type="hidden" name="post_id" value="<?php echo $comment['com_fk_pst'] ?>" />
          <input type="hidden" name="com_id" value="<?php  echo $comment['com_pk_id'] ?>" />
          <input type="hidden" name="user_id" value="<?php echo $comment['com_fk_usu']  ?>" />
          
    <?php }?>
      

<div class="form-group">

    <textarea class="form-control" id="text" name="text" rows="5" cols="100" 
              style="width: 100%; height: 300px;"><?= isset( $post['pst_text'] ) ?  $post['pst_text'] : $comment['com_text'] ?> </textarea>
  </div>
     <div class="form-group">      
     <button type="submit" class="btn btn-success">Salvar</button>
    <a href="<?= base_url('/') ?>"  class="btn btn-danger">Voltar</a>
      </div>
 <?php echo form_close() ?> 

        
        
<?= $this->endSection() ?>  