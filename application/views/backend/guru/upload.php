
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
  <p class="text-muted">Jadwal berdasarkan guru yang akan mengajar.</p>

  <?php $guru_id = $this->uri->segment(4);
  $guru = $this->db->query("SELECT name FROM guru WHERE user_id = '$guru_id'")->row() ?>
  <form action="<?=site_url('administrador/guru/upload-jadwal/'.$this->uri->segment(4)) ?>" method="POST">
		<div class="row">
			<div class="col-sm-9">
				<div class="card mb-4">
				  <div class="card-body">
				  	<div class="form-group">
				    	<label for="name" class="text-primary">Nama Guru</label>
				    	<input type="text" id="name" name="name" readonly class="form-control" 
				    	value="<?=$guru->name ?>">		
				    </div>

				  	<div class="form-group">
		        	<label for="pelajaran_id" class="text-primary">Pelajaran </label>
		        	<select name="pelajaran_id" class="form-control custom-select" id="pelajaran_id">
		        		<option value="">-- Pilih --</option>
		        		<?php foreach($mengajar as $mg) : ?>
		        		<?php $pl = $this->db->get_where('pelajaran', 
		        		array('id' => $mg['pelajaran_id']))->row_array() ?>
		        		<option value="<?=$mg['pelajaran_id'] ?>" 
		        			<?= set_select('pelajaran_id', $mg['pelajaran_id'], FALSE) ?>><?=$pl['nama_pelajaran'] ?></option>
		        		<?php endforeach ?>
		        	</select>
		        	<?=form_error('pelajaran_id', '<small class="text-danger">', '</small>') ?>
		        </div>

		        <div class="row">
				    	<div class="col">
				    		<div class="form-group">
				        	<label for="start_time" class="text-primary">Waktu Mulai</label>
				        	<input type="text" placeholder="00:00" id="start_time" name="start_time" 
				        	class="form-control" value="<?=set_value('start_time') ?>">	
				        	<?=form_error('start_time', '<small class="text-danger">', '</small>') ?>	
				        </div>
				    	</div>
				    	<div class="col">
				    		<div class="form-group">
				        	<label for="end_time" class="text-primary">Waktu Selesai</label>
				        	<input type="text" placeholder="00:00" id="end_time" name="end_time" 
				        	class="form-control" value="<?=set_value('end_time') ?>">	
				        	<?=form_error('end_time', '<small class="text-danger">', '</small>') ?>	
				        </div>
				    	</div>
				    </div>
				  </div>
				  <div class="card-footer">
				    <a href="<?=site_url('administrador/guru') ?>" class="btn btn-secondary">Batal</a>
				    <button class="btn btn-primary" type="submit">Simpan Jadwal</button>
				  </div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="card mb-4">
					<div class="card-body">
						<div class="form-group">
		        	<label for="kelas_id" class="text-primary">Kelas </label>
		        	<select name="kelas_id" class="form-control custom-select" id="kelas_id">
		        		<option value="">-- Pilih --</option>
		        		<?php foreach($kelas as $kl) : ?>
		        		<option value="<?=$kl['id'] ?>" 
		        			<?= set_select('kelas_id', $kl['id'], FALSE) ?>><?=$kl['nama_kelas'] ?></option>
		        		<?php endforeach ?>
		        	</select>
		        	<?=form_error('kelas_id', '<small class="text-danger">', '</small>') ?>
		        </div>

		        <div class="form-group">
				    	<label for="day" class="text-primary">Hari</label>
				    	<select class="form-control custom-select" name="day">
				    	<?php 
							$output = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] ?>
							<option value=""></option>
							<?php foreach ($output as $item) { ?>
								<option><?=$item ?></option>
							<?php } ?>	
							</select>
				    	<?=form_error('day', '<small class="text-danger">', '</small>') ?>
				    </div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

