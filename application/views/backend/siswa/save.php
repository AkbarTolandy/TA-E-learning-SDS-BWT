
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
  <p class="text-muted">Hanya siswa yang dapat mengakses upload dan download materi</p>

  <form action="<?=site_url('administrador/siswa/create') ?>" method="POST" class="mb-3">

		<div class="card mb-3">
			<div class="card-body">
				<div class="row">
					<div class="col-sm">
						<div class="form-group">
		        	<label for="kelas_id" class="text-primary">Tahun Ajaran </label>
		        	<select name="tahun_ajaran_id" class="form-control custom-select" id="tahun_ajaran_id">
		        		<option value="">-- Pilih --</option>
		        		<?php foreach($tahun_ajaran as $thn_ajaran) : ?>
		        		<option value="<?=$thn_ajaran['id'] ?>" 
		        			<?= set_select('tahun_ajaran_id', $thn_ajaran['id'], FALSE) ?>><?=$thn_ajaran['year'] ?></option>
		        		<?php endforeach ?>
		        	</select>
		        	<?=form_error('tahun_ajaran_id', '<small class="text-danger">', '</small>') ?>
		        </div>
					</div>
					<div class="col-sm-8">
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
					</div>
				</div>
			</div>
		</div>		

		<div class="row">
			<div class="col-sm-8">
				<div class="card mb-4">
					<div class="card-header mb-0">
            Data Siswa <hr>
          </div>
				  <div class="card-body">
				  	<div class="row">
				  		
				  		<div class="col-sm">
				  			<div class="form-group">
						    	<label for="name" class="text-primary">Nama Lengkap</label>
						    	<input type="text" placeholder="Nama Siswa" id="name" name="name" class="form-control" 
						    	value="<?=set_value('name') ?>">		
						    	<?=form_error('name', '<small class="text-danger">', '</small>') ?>
						    </div>
				  		</div>
				  		<div class="col-sm-4">
				  			<div class="form-group">
				        	<label for="number_phone" class="text-primary">Nomor Telepon</label>
				        	<input type="text" placeholder="+68" id="number_phone" name="number_phone" 
				        	class="form-control" value="<?=set_value('number_phone') ?>">		
						    	<?=form_error('number_phone', '<small class="text-danger">', '</small>') ?>
				        </div>
				  		</div>
				  	</div>

				    <div class="form-group">
              <label class="text-primary mr-5">Jenis Kelamin</label>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="gender" id="gender1" value="L">
							  <label class="form-check-label" for="gender1">Laki Laki</label>
							</div>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="gender" id="gender2" value="P">
							  <label class="form-check-label" for="gender2">Perempuan</label>
							</div>
							<div>
								<?=form_error('gender', '<small class="text-danger">', '</small>') ?>
							</div>
            </div>

				    <div class="form-group">
				    	<label for="address" class="text-primary">Alamat</label>
				    	<textarea name="address" cols="50" rows="3" id="address" class="form-control"><?=set_value('address') ?></textarea>
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-sm-4">

				<div class="card">
					<div class="card-header mb-0">
            Akun Login <hr>
          </div>
					<div class="card-body">
						<div class="form-group">
				    	<label for="username" class="text-primary">Username</label>
				    	<input type="text" id="username" name="username" placeholder="NIS Siswa sebagai: Username" 
				    	class="form-control" value="<?=set_value('username') ?>">
				    	<?=form_error('username', '<small class="text-danger">', '</small>') ?>
				    </div>

						<div class="form-group">
			        <label for="password" class="text-primary">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password" name="password">
							<?=form_error('password', '<small class="text-danger">', '</small>') ?>
			      </div>
						
						<div class="form-group">
			        <label for="password" class="text-primary">Confirm Password</label>
							<input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
							<?=form_error('password2', '<small class="text-danger">', '</small>') ?>
			      </div>

			      <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" value="1" id="is_active" name="is_active" <?php echo set_checkbox('is_active', '1') ?>>
							  <label class="custom-control-label" for="is_active">Status Siswa Diaktifkan?</label>
							</div>
				    </div>
					</div>
					<div class="card-footer">
				    <a href="<?=site_url('administrador/siswa') ?>" class="btn btn-secondary">Batal</a>
				    <button class="btn btn-primary" type="submit">Submit Data</button>
				  </div>
				</div>
			</div>
		</div>
	</form>
</div>

