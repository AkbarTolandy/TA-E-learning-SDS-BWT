<!-- Begin Page Content -->
<div class="container-fluid">
	<?php $link = site_url('administrador/guru') ?>

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?=$title ?>
  </h1>
	<div class="row mb-3">
		<?php if(!empty($guru)) : ?>
		<div class="col-sm-7 mb-3">
			<div class="card shadow">
		  	<div class="card-header">
		  		<img src="<?=base_url() ?>assets/backend/img/profile/<?=$guru->avatar ?>" class="img-thumbnail" width="100">
		  		<h3 class="mb-0 mt-3"><?=$guru->name ?> <span class="badge badge-secondary"><?=($guru->is_active == 1) ? 'active' : 'inactive'; ?></span></h3>
		  		<p>Sebagai Guru <u><?=($guru->gender == 'L') ? 'Laki Laki' : 'Perempuan' ?></u> </p>
		  	</div>
		  	<div class="card-body">
		  		<p>Tanggal Join: <br><?=date('d F Y H:i:s', strtotime($guru->created_at)) ?></p>
		  		<p>NIP Guru: <br><small class="text-danger">(digunakan sebagai username)</small> <br><?=$guru->username ?></p>
					<p>No Telepon: <br><?=$guru->number_phone ?></p>

					<a href="<?=$link ?>" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
					<a href="<?=site_url('administrador/guru/block/' .$guru->id) ?>" class="btn btn-<?=$guru->is_active ? 'danger' : 'warning' ?> btn-sm"><i class="fas fa-power-off"></i> <?=$guru->is_active ? 'InActive' : 'Active' ?></a>
		  	</div>
		  	
		  </div>
		</div> 

		<?php $pelajaran = $this->db->query("SELECT b.* FROM mengajar a JOIN pelajaran b 
		ON a.pelajaran_id = b.id AND a.guru_id = '$guru->id' ")->result_array() ?>

		<div class="col-sm">
			<div class="card">
				<div class="card-header">Data Pelajaran</div>

				<div class="card-body">
					<ul class="list-group list-group-flush">
						<?php if($pelajaran) : foreach($pelajaran as $pj) : ?>
					  <li class="list-group-item"><?=$pj['nama_pelajaran'] ?> </li>
					  <?php endforeach; else: ?>
					  <li class="list-group-item text-danger">Masih Kosong</li>
						<?php endif ?>
					</ul>
				</div>
			</div>
		</div>
		<?php else: ?>
		<div class="col-sm-12">
			<div class="alert alert-danger p-2">Guru Detail Masih Kosong</div>
		</div>
		<?php endif ?>

	</div>
</div>