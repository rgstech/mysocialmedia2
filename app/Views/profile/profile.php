
<?= $this->extend('/layouts/main_layout') ?>

<?= $this->section('content') ?>


<div class="container">
  <div class="row">
    <div class="col-md-6 img">
      <img src="<?php echo base_url('public/'.$userData['usu_img'])?>" alt="profile-img" class="rounded-circle" width="190" height="190">
    </div>
    <div class="col-md-6 details">
      <blockquote>
        <h5><?=  htmlspecialchars($userData['usu_nome']) ?></h5>
        <small><cite title="Source Title"> <?= htmlspecialchars($userData['usu_bio']) ?> <i class="icon-map-marker"></i></cite></small>
      </blockquote>
      <p>
        <?=  $userData['usu_email'] ?> <br>
       
      </p>
    </div>
  </div>
</div>


<?= $this->endSection() ?>  