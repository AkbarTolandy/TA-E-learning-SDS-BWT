
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    </div>

    <?=$this->session->flashdata('message') ?>

		<div class="row">
	    <!-- Earnings (Monthly) Card Example -->
	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-primary shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Video</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Earnings (Monthly) Card Example -->
	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-success shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Siswa</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-user-friends fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Earnings (Monthly) Card Example -->
	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-info shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Guru</div>
	              <div class="row no-gutters align-items-center">
	                <div class="col-auto">
	                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0</div>
	                </div>
	                <div class="col">
	                  <div class="progress progress-sm mr-2">
	                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="col-auto">
	             	<i class="fas fa-file-invoice fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Pending Requests Card Example -->
	    <div class="col-xl-3 col-md-6 mb-4">
	      <div class="card border-left-warning shadow h-100 py-2">
	        <div class="card-body">
	          <div class="row no-gutters align-items-center">
	            <div class="col mr-2">
	              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Materi</div>
	              <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
	            </div>
	            <div class="col-auto">
	              <i class="fas fa-comments fa-2x text-gray-300"></i>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>

	  <div class="row">
	  	<div class="col-sm-8">
	  		<div class="card shadow mb-4">
	  			<div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Akun User</h6>
          </div>
          <div class="card-body">
          	<a href="<?=site_url('administrador/admin/create') ?>" class="btn btn-primary btn-sm mb-3">Tambah Akun</a>
						<div class="table-responsive">
	            <table class="table table-striped">
							  <thead>
							    <tr>
							      <th scope="col">No</th>
							      <th scope="col">User Login</th>
							      <th scope="col">Active</th>
							      <th scope="col">Role</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php $no = 1; foreach($user_admin as $us) : ?>
							  	<tr>
							  		<td><?=$no++ ?></td>
							  		<td><?=$us->username ?></td>
							  		<td><span class="badge badge-<?=($us->is_active == 1) ? 'secondary' : 'danger'  ?>"><?=($us->is_active == 1) ? 'Enable' : 'Disabled'  ?></span></td>
							  		<td><?=$us->role_name ?></td>
							  		<td><a href="<?=site_url('administrador/admin/edit/' .$us->id) ?>" class="badge badge-warning">Edit</a> 
							  			<a onclick="return confirm('Data Admin Ingin Di Hapus?')" href="<?=site_url('administrador/admin/delete/' .$us->id) ?>" class="badge badge-danger">Delete</a></td>
							  	</tr>
							  	<?php endforeach ?>
							  </tbody>
							</table>
						</div>
						<div class="card-footer">
							<mark>Note: </mark>
							<small class="text-danger">Data Akun jika didelete maka data detail user akan terhapus.</small>
						</div>
          </div>
	  		</div>
	  	</div>

	  </div>

  </div>
  <!-- /.container-fluid -->


      