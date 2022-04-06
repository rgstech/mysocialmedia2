

<?= $this->extend('/layouts/main_layout') ?>

<?= $this->section('content') ?>

<script>
   
function refreshLikesPost(pid, uid, elemento) // like and refresh like count / registra um like e atualiza os dados na view
{                                                
        $.ajax({
          url: '<?= base_url("post/like/" ) ?>' + '/' + pid + "/" + uid,
          cache: false,
          success: function(data){
              elemento.innerHTML = " " + data; 
          } 
        }); 
}

</script>
 

<?php if($posts) { foreach ($posts as $post) { ?>
<div class="media border p-3">
    <a  href="<?= base_url('user/showprofile/'. $post->uid) ?>" ><img src="<?php echo base_url('public/'.$post->image)?>" alt="<?= $post->nome ?>" class="mr-3 mt-3 rounded-circle" style="width:60px;"> </a>
  <div class="text-message media-body">
    <h4><?= $post->nome ?> <small><i>Postado em <?= formatDate($post->data)?></i></small></h4>
    <p><?= htmlspecialchars($post->texto) ?></p>
   
      <div class="form-group">
          <button class="btn btn-primary"> <i class="fa fa-heart" aria-hidden="true"></i> <span  onclick="refreshLikesPost(<?= $post->pid ?>, <?= session()->get('id')  ?> ,this)"><?= $post->qtdlike ?></span></button>
          <a href="<?= base_url('comment/show/'.$post->pid) ?>" class="btn btn-success"><i class="fa fa-comment" aria-hidden="true"></i> <?= $post->qtdcom ?> </a>
        <?php  if (session()->get('id') == $post->uid) { ?>
            <a href="<?= base_url('post/edit/' . $post->pid) ?>" class="btn btn-warning"> <i class="fa fa-address-book" aria-hidden="true"></i> editar</a>
            <a href="<?= base_url('post/delete/' . $post->pid) ?> " class="btn btn-danger" > <i class="fa fa-trash" aria-hidden="true"></i> excluir</a>
        <?php } ?>
    </div>
  </div>
     
</div>
<?php } } else { ?>
 <div class="alert alert-info">
    <strong>Opa!</strong> Ainda não há postagem aqui!.
  </div>
<?php }?>
<hr>
 <?php echo $pager->links(); ?>

<?= $this->endSection() ?>  