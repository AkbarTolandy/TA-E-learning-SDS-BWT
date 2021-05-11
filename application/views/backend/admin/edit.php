
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
  <p class="text-muted">Melakukan Proses Update Data Admin</p>

  <form action="<?=site_url('administrador/admin/edit/' .$profile->id) ?>" method="POST">
		<div class="row">
			<div class="col-sm-9">
				<div class="card mb-4">
				  <div class="card-body">
				    <div class="form-group">
				    	<label for="fullname" class="text-primary">Nama Lengkap</label>
				    	<input type="text" placeholder="Name" id="fullname" name="fullname" class="form-control" value="<?=$profile->name ?>">		
				    	<?=form_error('fullname', '<small class="text-danger">', '</small>') ?>
				    </div>

				    <div class="form-group">
				    	<label for="username" class="text-primary">Username</label>
				    	<input type="text" readonly id="username" name="username" placeholder="Username" class="form-control" value="<?=$profile->username ?>">
				    	<?=form_error('username', '<small class="text-danger">', '</small>') ?>
				    </div>

				  </div>
				  <div class="card-footer">
				    <a href="<?=site_url('administrador/admin') ?>" class="btn btn-secondary">Batal</a>
				    <button class="btn btn-primary" type="submit">Update Admin</button>
				  </div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="card mb-4">
					<div class="card-body">
						<div class="form-group">
		        	<label for="role_id" class="text-primary">Role</label> <small>: sebagai</small>
		        	<select name="role">
		        		<option value="1" <?=($profile->role_id == '1') ? 'selected' : '' ?>>Tata Usaha</option>
		        		<option value="4" <?=($profile->role_id == '4') ? 'selected' : '' ?>>Kepala Sekolah</option>
		        	</select>
		        </div>

		        <div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" value="1" id="is_active" name="is_active" 
							  <?=$profile->is_active ? 'checked' : '' ?>>
							  <label class="custom-control-label" for="is_active">admin diaktifkan?</label>
							</div>
				    </div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

