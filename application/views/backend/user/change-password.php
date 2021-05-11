

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    <p class="mb-4">Jagalah informasi akun sebaik mungkin</p>
		<div class="row">
			<div class="col-lg-6">
				<?=$this->session->flashdata('message') ?>

				<div class="card mb-4">
					<div class="card-body">
						<form action="<?=site_url('administrador/user/change-password') ?>" method="post">
							<div class="form-group">
						    <label for="password1">Current Password</label>
						    <input type="password" name="current_password" class="form-control" id="password1" placeholder="Password Lama">
						    <?=form_error('current_password', '<small class="text-danger">', '</small>') ?>
						  </div>

						  <div class="form-group">
						    <label for="password2">New Password</label>
						    <input type="password" name="new_password1" class="form-control" id="password2" placeholder="Password Baru (Min. 8 Karakter)">
						    <?=form_error('new_password1', '<small class="text-danger">', '</small>') ?>
						  </div>

						  <div class="form-group">
						    <label for="password3">Repeat Password</label>
						    <input type="password" name="new_password2" class="form-control" id="password3" placeholder="Confirm Password Baru">
						    <?=form_error('new_password2', '<small class="text-danger">', '</small>') ?>
						  </div>

						  <div class="form-group">
						  	<button type="submit" class="btn btn-primary">Change Password</button>
						  </div>
						</form>
					</div>
				</div>
			</div>
		</div>
  </div>
  <!-- /.container-fluid -->


      