<?php use Carbon\Carbon; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Home</a></li>
      <li class="breadcrumb-item">Pages</li>
      <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
    </ol>
  </div>

 	<p class="pt-3">Pelajari satu persatu <b>Pelajaran</b> yang ingin kalian pelajari!</p>

  <div class="mt-3 mb-3">
  	<div class="card-body">
  		<div class="row" id="result-course">
  			<?php if($pelajaran) : foreach($pelajaran as $m) : ?>

  			<div class="col-sm-2 mb-3">
          <?php $p = $this->db->get_where('pelajaran', ['id' => $m->pelajaran_id])->row() ?>
				  <div class="card card-body text-center">
				  	<?php $link = 'administrador/tugas/detail/' .$m->pelajaran_id; ?>
				    <h5 class="card-title"><a href="<?=site_url($link) ?>"><?=$p->nama_pelajaran ?></a></h5>
				    <h6 class="card-subtitle mb-2 text-muted"></h6>
            <p> <?= $m->hari; ?>, <?= $m->waktu_mulai; ?> - <?= $m->waktu_selesai; ?> </p>
				    <div class="d-flex justify-content-between">
              <small>Total :</small>
              <?php $materi = $this->db->get_where('materi', ['pelajaran_id' => $m->pelajaran_id]) ?>
				    	<small><i class="fa fa-file"></i> <?=$materi->num_rows() ?> Materi</small>
				    </div>
				  </div>
  			</div>
  			<?php endforeach; else: ?>
					<div class="col-sm-12">
						<div class="p-1 bg-danger text-white">Pelajaran Belum Tersedia..</div>
					</div>
	  		<?php endif ?>
  		</div>
  	</div>
  </div>
</div>