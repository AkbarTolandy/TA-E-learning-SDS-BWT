<!-- Begin Page Content -->
<div class="container-fluid">
	<?php $link = site_url('administrador/siswa') ?>

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?=$title ?>
  </h1>
	<div class="row">
		<?php if(!empty($siswa)) : ?>
		<div class="col-sm-6">
			<div class="card shadow">
		  	<div class="card-header">
		  		<?php if(!empty($siswa->avatar)) { ?>
		  			<img src="<?=base_url() ?>assets/backend/img/profile/<?=$siswa->avatar ?>" 
		  		class="img-thumbnail" width="100">
		  		<?php } else { ?>
		  			<img src="<?=base_url() ?>assets/backend/img/profile/default.png" class="img-thumbnail" width="100">
		  		<?php } ?>
		  		<h4 class="mb-0 mt-3"><?=$siswa->name ?> <span class="badge badge-secondary"><?=($siswa->is_active == 1) ? 'active' : 'inactive'; ?></span></h4>
		  		<p class="text-muted">Sebagai Siswa <u><?=($siswa->gender == 'L') ? 'Laki Laki' : 'Perempuan' ?></u></p class="text-muted">
		  	</div>
		  	<div class="card-body">
		  		<strong>Bergabung Sejak : </strong>
		  		<p><?=date('d F Y H:i:s', strtotime($siswa->created_at)) ?></p>
					<dl class="row">
					  <dt class="col-sm-9">NIS Siswa <br>
					  (<span class="text-danger">yg digunakan sebagai username</span>)</dt>
					  <dd class="col-sm-3"><mark><?=$siswa->username ?></mark></dd>
					  
					</dl>

					<dl class="row">
					  <dt class="col-sm-4">Telepon</dt>
					  <dd class="col-sm-8">
					    <p><?=$siswa->number_phone ?></p>
					  </dd>

					  <dt class="col-sm-4">Alamat</dt>
					  <dd class="col-sm-8">
					    <p><?=$siswa->address ?></p>
					  </dd>
					</dl>

					<a href="<?=$link ?>" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
					<a href="<?=site_url('administrador/siswa/block/' .$siswa->id) ?>" class="btn btn-<?=$siswa->is_active ? 'danger' : 'warning' ?> btn-sm"><i class="fas fa-power-off"></i> <?=$siswa->is_active ? 'InActive' : 'Active' ?></a>
		  	</div>
		  	
		  </div>
		</div> 

		<?php $this->db->select('kode_kelas, nama_kelas');
		$kelas = $this->db->get_where('kelas', array('id' => $siswa->kelas_id))->row_array();

		$this->db->select('year');
		$tahun_ajaran = $this->db->get_where('tahun_ajaran', 
		array('id' => $siswa->tahun_ajaran_id))->row_array() ?>

		<div class="col-sm">
			<div class="card">
				<div class="card-header">Data Kelas</div>

				<div class="card-body">
					<ul class="list-group list-group-flush">
					  <li class="list-group-item"><mark>Tahun Pelajaran</mark> <br> <?=$tahun_ajaran['year'] ?></li>
					  <li class="list-group-item"><mark>Kelas</mark> <br> <?= $kelas['kode_kelas'] ?> <?=$kelas['nama_kelas'] ?></li>
					</ul>
				</div>
			</div>
		</div>
		<?php else: ?>
		<div class="col-sm">
			<div class="alert alert-danger p-2">Siswa Detail Masih Kosong</div>
		</div>
		<?php endif ?>
	</div>
</div>