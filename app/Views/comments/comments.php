<?= $this->extend('/layouts/main_layout') ?>

<?= $this->section('content') ?>


<script>
   
function refreshLikesCom(cid, uid, elemento)
{
        $.ajax({
          url: '<?= base_url("comment/like/" ) ?>' + '/' + cid + "/" + uid,
          cache: false,
          success: function(data){
              elemento.innerHTML = " " + data;
          } 
        }); 
}

</script>

     
<div class="media border p-3 box-component">
    <a  href="<?= base_url('user/showprofile/'. $post->uid) ?>" ><img src="<?php echo base_url('public/'.$post->image)?>" alt="<?= $post->nome ?>" class="mr-3 mt-3 rounded-circle" style="width:60px;"></a>
  <div class="text-message media-body">
    <h4><?= $post->nome ?> <small><i>Postado em <?= formatDate($post->data)?></i></small></h4>
    <p><?= htmlspecialchars($post->texto) ?></p>
   
      <div class="form-group">
<!--          <a href=#" class="btn btn-primary"><i class="fa fa-heart" aria-hidden="true"></i></a>-->
       <?php  if (session()->get('id') == $post->uid) { ?>
        <a href="<?= base_url('post/edit/' . $post->pid) ?>" class="btn btn-warning"><i class="fa fa-address-book" aria-hidden="true"></i> editar</a>
        <a href="<?= base_url('post/delete/' . $post->pid) ?>" class="btn btn-danger" > <i class="fa fa-trash" aria-hidden="true"></i> excluir</a>
       <?php }  ?>
    </div> 
    <?php foreach($comments as $comment) { ?>
     <div class="media p-3">
         <a  href="<?= base_url('user/showprofile/'. $post->uid) ?>" ><img src="<?php echo base_url('public/'.$comment->image)?>" alt="user" class="mr-3 mt-3 rounded-circle" style="width:45px;"></a>
      <div class="text-message media-body">
        <h4><?= $comment->nome ?> <small><i>Postado em <?= formatDate($comment->data)?></i></small></h4>
        <p><?= htmlspecialchars($comment->texto) ?></p>
          <div class="form-group">
              <button class="btn btn-primary"> <i class="fa fa-heart" aria-hidden="true"></i> <span  onclick="refreshLikesCom(<?= $comment->cid ?>, <?= session()->get('id')  ?> ,this)"><?= $comment->qtdlike ?></span></button>
         <?php  if (session()->get('id') == $comment->uid) { ?>
          <a href="<?= base_url('comment/edit/' . $comment->cid) ?>" class="btn btn-warning"><i class="fa fa-address-book" aria-hidden="true"></i> editar</a>
          <a href="<?= base_url('comment/delete/'.$comment->cid . '/' . $post->pid) ?>" class="btn btn-danger" > <i class="fa fa-trash" aria-hidden="true"></i> excluir</a>
          <?php }  ?>
    </div>
      </div>
    </div> 
    <?php } ?>
    <hr>
      <div class = "cointainer">
           <div class="row">
          <div class = "col-sm-12 ">
                <?php echo form_open('comment/save',  ['class' => 'pull_right']) ?>
           
               <input type="hidden" name="post_id" value="<?php echo $post->pid ?>" />
                     
                <input type="hidden" name="user_id" value="<?php echo session()->get('id') ?>" />
              
                	<h3>Escrever um novo comentário</h3>
                    <fieldset>       
                            <div class="form-group ">
                                <textarea class="form-control" id="texto" name="text"  cols="30" rows="10" placeholder=" ...Digite aqui um comentário" required=""></textarea>
                            </div>               
                    </fieldset> 
                        
                      
            <div class = "col-sm-1"> <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i>Enviar</button></div>
                <?php echo form_close() ?> 
          </div>
           </div>
         
         </div>   
  </div>
         
</div>



<?= $this->endSection() ?>  