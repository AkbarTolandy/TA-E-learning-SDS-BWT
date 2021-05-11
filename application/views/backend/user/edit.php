

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    <p class="mb-4">Lengkapi Data Profile Kamu</p>
    <form action="<?=site_url('administrador/user/edit') ?>" method="POST" enctype="multipart/form-data">
		<div class="row mb-3">
			<div class="col-lg-7">
				<?php if($this->session->userdata('role_id') == 3) {
					$data = $this->db->get_where('siswa', ['user_id' => $user['id']])->row_array(); 

				} else if($this->session->userdata('role_id') == 2) {
      		$data = $this->db->get_where('guru', ['user_id' => $user['id']])->row_array();

				} else { 
					$data = $this->db->get_where('administrator', ['user_id' => $user['id']])->row_array(); 
				} ?>

				<div class="card mb-4">
					<div class="card-body">
						<div class="form-group row">
					    <label for="username" class="col-sm-3 col-form-label">User Login</label>
					    <div class="col-sm-9">
					      <input type="text" name="username" value="<?=$user['username'] ?>" class="form-control" id="username" readonly>
					    </div>
					  </div>

					  <div class="form-group row">
					    <label for="name" class="col-sm-3 col-form-label">Nama Lengkap</label>
					    <div class="col-sm-9">
					      <input type="text" value="<?=$data['name'] ?>" name="name" class="form-control" id="name">
					       <?=form_error('name', '<small class="text-danger">', '</small>') ?>
					    </div>
					  </div>

					  <div class="form-group row">
					    <label class="col-sm-3 col-form-label">Photo</label>
					    <div class="col-sm-9">
					      <div class="row">
					      	<div class="col-sm-3">
					      		<img src="<?=base_url() ?>assets/backend/img/profile/<?=$data['avatar'] ?>" class="img-thumbnail">
					      	</div>
					      	<div class="col-sm-9">
					      		<div class="custom-file">
										  <input type="file" name="image" class="custom-file-input" id="image">
										  <label class="custom-file-label" for="image">Choose file</label>
										</div>
										<?=$this->session->flashdata('error-upload') ?>
					      	</div>
					      </div>
					    </div>
					  </div>

					  <div class="form-group row justify-content-end">
					  	<div class="col-sm-9">
					  		<button type="submit" class="btn btn-primary">Edit Profile</button>
					  	</div>
					  </div>
					</div>
				</div>

			</div>
			<div class="col">
				<div class="card">
					<div class="card-body">
						<?php if($this->session->userdata('role_id') == 2) { ?>
						<div class="form-group">
              <label for="number_phone">Nomor Telepon</label>
              <input type="text" class="form-control" id="number_phone" name="number_phone" placeholder="+62" value="<?=$data['number_phone'] ?>">
            </div>
            
            <div class="form-group">
              <label>Jenis Kelamin</label>
              <div class="custom-control custom-radio">
                <input type="radio" id="gender1" name="gender" class="custom-control-input" value="L" <?=$data['gender'] == 'L' ? 'checked' : '' ?>>
                <label class="custom-control-label" for="gender1">Laki Laki</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="gender2" name="gender" class="custom-control-input" value="P" <?=$data['gender'] == 'P' ? 'checked' : '' ?>>
                <label class="custom-control-label" for="gender2">Perempuan</label>
              </div>
            </div>
          	<?php } else if($this->session->userdata('role_id') == 3) { ?>

          	<div class="form-group">
              <label for="number_phone">Nomor Telepon</label>
              <input type="text" class="form-control" id="number_phone" name="number_phone" placeholder="+62" value="<?=$data['number_phone'] ?>">
            </div>

            <div class="form-group">
              <label>Jenis Kelamin</label>
              <div class="custom-control custom-radio">
                <input type="radio" id="gender1" name="gender" class="custom-control-input" value="L" <?=$data['gender'] == 'L' ? 'checked' : '' ?>>
                <label class="custom-control-label" for="gender1">Laki Laki</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="gender2" name="gender" class="custom-control-input" value="P" <?=$data['gender'] == 'P' ? 'checked' : '' ?>>
                <label class="custom-control-label" for="gender2">Perempuan</label>
              </div>
            </div>

            <div class="form-group">
              <label for="address">Alamat</label>
              <textarea class="form-control" id="address" name="address" placeholder="Alamat Lengkap" rows="3"><?=$data['address'] ?></textarea>
            </div>
          	<?php } else { ?>
          	<p>tidak memiliki detail profile.</p>
          	<?php } ?>
					</div>
				</div>
			</div>
		</div>
		</form>
  </div>
  <!-- /.container-fluid -->


      