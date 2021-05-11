
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
  <p class="text-muted">Registrasi Admin Baru</p>

  <form action="<?=site_url('administrador/admin/create') ?>" method="POST">
		<div class="row">
			<div class="col-sm-9">
				<div class="card mb-4">
				  <div class="card-body">
				    <div class="form-group">
				    	<label for="fullname" class="text-primary">Nama Lengkap</label>
				    	<input type="text" placeholder="Name" id="fullname" name="fullname" class="form-control" value="<?=set_value('fullname') ?>">		
				    	<?=form_error('fullname', '<small class="text-danger">', '</small>') ?>
				    </div>

				    <div class="form-group">
				    	<label for="username" class="text-primary">Username</label>
				    	<input type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?=set_value('username') ?>">
				    	<?=form_error('username', '<small class="text-danger">', '</small>') ?>
				    </div>

				    <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" value="1" id="is_active" name="is_active" <?php echo set_checkbox('is_active', '1') ?>>
							  <label class="custom-control-label" for="is_active">Akun Admin diaktifkan?</label>
							</div>
				    </div>
				  </div>
				  <div class="card-footer">
				    <a href="<?=site_url('administrador/admin') ?>" class="btn btn-secondary">Batal</a>
				    <button class="btn btn-primary" type="submit">Register Admin</button>
				  </div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="card mb-4">
					<div class="card-body">
						<div class="form-group">
		        	<label for="role_id" class="text-primary">Role: </label> <small>sebagai</small>
		        	<select name="role">
		        		<option value="1">Tata Usaha</option>
		        		<option value="4">Kepala Sekolah</option>
		        	</select>
		        </div>
					</div>
				</div>

				<div class="card mb-4">
					<div class="card-body">
						<div class="form-group">
			        <label for="password" class="text-primary">Password</label>
							<input type="password" class="form-control" id="password" placeholder="Password" name="password">
							<?=form_error('password', '<small class="text-danger">', '</small>') ?>
			      </div>

			      <div class="form-group">
			        <label for="password2" class="text-primary">Confirm Password</label>
							<input type="password" class="form-control" id="password2" placeholder="Ulangi Password" name="password2">
							<?=form_error('password2', '<small class="text-danger">', '</small>') ?>
			      </div>

			      
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

