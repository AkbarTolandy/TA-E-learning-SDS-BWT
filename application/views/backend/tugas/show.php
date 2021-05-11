<?php use Carbon\Carbon; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<div class="d-sm-flex align-items-center justify-content-between">
		<div>
			<h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
			<p></p>
		</div>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item">Pages</li>
			<li class="breadcrumb-item active">Blank Page</li>
		</ol>
	</div>

	<?php $kelas_id = $this->session->userdata('kelas_id') ?>
	<?php $mengajar = $this->db->query("SELECT id, guru_id, kelas_id FROM mengajar 
		WHERE pelajaran_id = '$pelajaran->id' AND kelas_id = '$kelas_id' ")->row();

	$guru = [];

	if($mengajar) :
		$guru = $this->db->query("SELECT * FROM guru 
			WHERE user_id = '$mengajar->guru_id'")->row();
		endif ?>

		<div class="card-body">
			<div class="row mb-3">
				<div class="col-sm-7">
					<?=$this->session->flashdata('message') ?>

					<h5 class="pt-3"><b>Tentang Pelajaran</b></h5>
					<p><?=$pelajaran->nama_pelajaran ?></p>

					<h5 class="pt-3"><b>Status</b></h5>
					<p><?=$pelajaran->status ? 'Aktif' : 'Tidak Aktif' ?></p>
				</div>


				<div class="col">

					<div class="card">
						<div class="card-header">
							<h6 class="font-weight-bold">Sebagai Pengajar </h6>
						</div>
						<?php if($guru) : ?>
							<div class="card-body">
								<div class="media">
									<img src="<?=base_url() ?>assets/backend/img/profile/<?=$guru->avatar ?>" class="mr-3 img-thumbnail rounded" width="100">
									<div class="media-body">
										<h5 class="mt-0 mb-0 font-weight-bold"></h5>
										<h6><?=$guru->name; ?></h6>
										<p><?=$guru->number_phone; ?></p>
									</div>
								</div>
							</div>
							<?php else: ?>
								<div class="card-body">
									<p class="alert-danger p-1 text-white">pelajaran ini belum ada gurunya.</p>
								</div>
							<?php endif ?>
						</div>

					</div>
				</div>


				<?php $materi = $this->db->query("SELECT * FROM materi 
				WHERE pelajaran_id = '$pelajaran->id' ")->result() ?>

				<div class="row">
					<div class="col-sm-7">
						<h4>Pertemuan</h4>
						<div id="accordion">
							<?php if($materi) : foreach($materi as $m) : ?>
								<div class="card">
									<div class="card-header" id="headingOne">
										<h5 class="mb-0">
											<button data-toggle="collapse" data-target="#<?=$m->slug ?>">
												<i class="fa fa-sticky-note"></i> <?=$m->title ?> #BAB <?=$m->bab ?>
											</button>
										</h5>
									</div>

									<div id="<?=$m->slug ?>" class="collapse show" data-parent="#accordion">
										<div class="card-body">
											<p>Deskripsi: </p>
											<?=$m->description ?>

				        <!-- <p>Prasyarat: </p>
				        	<?=$m->precondition ?> -->

				        	<p><span class="badge badge-<?=$m->is_publish ? 'primary' : 'danger' ?>"><?=$m->is_publish ? 'Aktif' : 'Tidak aktif' ?></span></p>

				        	<p> <a href="<?=base_url('assets/backend/tmp/materi/'.$m->document) ?>" 
				        		class="btn btn-sm btn-outline-primary"><i class="fa fa-file-download"></i> Download Disini</a></p>
				        	</div>
				        </div>
				    </div>
				<?php endforeach; else: ?>
				<div class="card card-body">
					<p class="alert-danger p-1 text-white">materi masih kosong..</p>
				</div>
			<?php endif ?>
		</div>


	</div>
	<div class="col-sm-5">
		<?php if($this->session->userdata('role_id') == 3) {
			$table = 'siswa';
		} else if($this->session->userdata('role_id') == 2) {
			$table = 'guru';
		} else {
			$table = 'administrator';
		} ?>

		<?php $cekAbsen = $this->db->get_where('absen', [
			'siswa_id' => $user['id']
		])->row_array() ?>

		<div class="card">
			<div class="card-header">
				<h6 class="font-weight-bold">Kehadiran </h6>
			</div>
			<div class="card-body">
				<form action="<?=site_url('administrador/tugas/absen') ?>" method="POST">
					<div class="d-flex justify-content-between">
						<?php $u = $this->db->get_where($table, array('user_id' => $user['id']))->row_array(); ?>
						<p><i class="fa fa-user"></i> <?= $u['name'] ?></p>

						<p><i class="fa fa-clock"></i> <?= date('H:i:s') ?></p>

						<input type="hidden" name="pelajaran_id" value="<?=$pelajaran->id ?>">
					</div>

					<p>silahkan tekan tombol absen</p>
					<button type="submit" class="btn btn-outline-success btn-block"> Saya Hadir </button>
				</form>
			</div>
		</div>

		<div class="card mt-3 mb-3">
			<div class="card-header">
				<h6 class="font-weight-bold">Upload Tugas </h6>
			</div>
			<div class="card-body">
				<form action="<?=site_url('administrador/tugas/detail/' .$pelajaran->id) ?>" enctype="multipart/form-data" method="POST">
					<input type="hidden" name="pelajaran_id" value="<?=$pelajaran->id ?>">				
					<div class="form-group">
						<label id="materi_id" class="font-weight-bold">Pilih Materi</label>
						<select name="materi_id" class="form-control custom-select">
							<?php if($materi) : foreach($materi as $m) : ?>
								<option value="<?=$m->id?>"><?=$m->title ?> #BAB <?=$m->bab ?></option>
							<?php endforeach; endif ?>
						</select>
						<?=form_error('materi_id', '<small class="text-danger">', '</small>') ?>
					</div>

					<div class="form-group">
						<label class="font-weight-bold">File</label>
						<div class="custom-file">
							<input type="file" name="file" class="custom-file-input" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						<?=$this->session->flashdata('error-upload') ?>
						<?=form_error('file', '<small class="text-danger">', '</small>') ?>
					</div>

					<div class="form-group">
						<button class="btn btn-outline-primary">Submit</button>
						<a href="<?=site_url('administrador/tugas') ?>" class="btn btn-outline-primary"><i class="fa fa-angle-left"></i> Kembali Ke Daftar Pelajaran </a>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

</div>
</div>