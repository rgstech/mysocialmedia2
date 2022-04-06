<?= $this->extend('/layouts/main_layout') ?>

<?= $this->section('content') ?>

<style>

.tab-pane {

  background-color: whitesmoke;
  /* overflow-y: auto; */
  color: black;
  /* max-height: 600px; */
  min-height: 100px;
  padding: 5px;

}

/*==================================================
  Nearby People CSS
  ==================================================*/
.people-nearby .google-maps{

  background: #f8f8f8;
  border-radius: 4px;
  border: 1px solid #f1f2f2;
  padding: 20px;
  margin-bottom: 20px;

}

.people-nearby .google-maps .map{

  height: 300px;
  width: 100%;
  border: none;

}

.people-nearby .nearby-user{

  padding: 20px 0;
  border-top: 1px solid #f1f2f2;
  border-bottom: 1px solid #f1f2f2;
  margin-bottom: 20px;

}

img.profile-photo-lg{

  height: 80px;
  width: 80px;
  border-radius: 50%;

}

</style>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" 
               href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Usuarios (<?php if ($users){ echo count($users); } else { echo 0; } ?>)</a>
        </li>
        <li class="nav-item" role="presentation">
             <a class="nav-link" id="pills-profile-tab" data-toggle="pill" 
             href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Posts (<?php if ($posts){ echo count($posts); } else { echo 0; } ?>)</a>
        </li>
        <li class="nav-item" role="presentation">
             <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" 
             role="tab" aria-controls="pills-contact" aria-selected="false">Comentários (<?php if ($comments){ echo count($comments); } else { echo 0; } ?>)</a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"> <!-- inicio aba  -->
        
      <div class="container">  <!-- start card container -->
         <?php   if ($users) { foreach($users as $user) { ?>
        <div class="row">
            <div class="col-md-8">
                <div class="people-nearby">
                  
                  <div class="nearby-user">
                    <div class="row">
                      <div class="col-md-2 col-sm-2">
                      <img src="<?= base_url('public/'.$user->img) ?>" alt="user" class="profile-photo-lg"> 
                      </div>
                      <div class="col-md-7 col-sm-7">
                        <h5><a href="<?= base_url('user/showprofile/'. $user->uid) ?>" class="profile-link"><?= htmlspecialchars($user->nome) ?></a></h5>
                        <!-- <p>Software Engineer</p> -->
                        <p class="text-muted"><?= htmlspecialchars($user->bio) ?></p>
                      </div>
                      <div class="col-md-3 col-sm-3">
                        <a href="<?= base_url('user/showprofile/'. $user->uid) ?>" class="btn btn-primary pull-right">Ver perfil</a>
                      </div>
                    </div>
                  </div>

                </div>
            </div>
        </div>

        <?php } } else { ?>
          <div class="alert alert-info">
             <strong>Opa!</strong> Sua busca não retornou nenhum resultado aqui!
          </div>  
          <?php }?>
      </div>      <!-- end card container -->
      </div> <!-- fim aba  -->

      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"> <!-- inicio aba  -->
      <div class="container"> <!-- start card container --> 
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
            <strong>Opa!</strong> Sua busca não retornou nenhum resultado aqui!
        </div>
        <?php }?>
</div> <!-- end card container -->
      </div> <!-- fim aba  -->
      
      <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"> <!-- inicio aba  -->
      <div class="container"> <!-- start card container -->
      <?php if($comments) { foreach($comments as $comment) { ?>
     <div class="media p-3">
         <a  href="<?= base_url('user/showprofile/'. $comment->uid) ?>" ><img src="<?php echo base_url('public/'.$comment->image)?>" alt="user" class="mr-3 mt-3 rounded-circle" style="width:45px;"></a>
      <div class="text-message media-body">
        <h4><?= $comment->nome ?> <small><i>Postado em <?= formatDate($comment->data)?></i></small></h4>
        <p><?= htmlspecialchars($comment->texto) ?></p>
          <div class="form-group">
              <button class="btn btn-primary"> <i class="fa fa-heart" aria-hidden="true"></i> <span  onclick="refreshLikesCom(<?= $comment->cid ?>, <?= session()->get('id')  ?> ,this)"><?= $comment->qtdlike ?></span></button>
         <?php  if (session()->get('id') == $comment->uid) { ?>
          <a href="<?= base_url('comment/edit/' . $comment->cid) ?>" class="btn btn-warning"><i class="fa fa-address-book" aria-hidden="true"></i> editar</a>
          <a href="<?= base_url('comment/delete/'.$comment->cid . '/' . $comment->pid) ?>" class="btn btn-danger" > <i class="fa fa-trash" aria-hidden="true"></i> excluir</a>
          <?php }  ?>
          <a href="<?= base_url('comment/show/'.$comment->pid) ?>" class="btn btn-success" > <i class="fas fa-eye"></i> Ver Post</a>
    </div>
      </div>
    </div> 
    <?php }  } else {?>
      <div class="alert alert-info">
             <strong>Opa!</strong> Sua busca não retornou nenhum resultado aqui!
      </div>  
    <?php }?>

    </div> <!-- end card container -->
      </div> <!-- fim aba  -->
    </div>



<?= $this->endSection() ?>