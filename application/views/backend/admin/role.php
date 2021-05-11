
	<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
		<div class="row">
			<div class="col-sm-6">
				<?=$this->session->flashdata('message') ?>

				<div class="card mb-4">
					<?php if($this->uri->segment(3) !== 'edit') : ?>
					<div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Tambah Role Baru</h5>
            <p>Untuk bisa mengakses beberapa menu yang terkait.</p>
          </div>
        	<?php endif ?>
					<div class="card-body">

						<?php
						if($this->uri->segment(3) == 'edit') :
			        $url = site_url('administrador/role/edit/'.$role->id);
			      else:
			        $url = site_url('administrador/admin/role');
			      endif ?>

						<form action="<?=$url ?>" method="POST">
				    	<div class="form-group">
				    		<input type="text" class="form-control" name="role" id="role" placeholder="Role" 
				    			value="<?=($this->uri->segment(3) == 'edit') ? $role->role_name : set_value('role') ?>">
				      	<?=form_error('role', '<small class="text-danger">', '</small>') ?>
				    	</div>
				      
				      <button class="btn btn-primary" type="submit">Simpan Data</button>
				      <?php if($this->uri->segment(3) == 'edit') : ?>
				      <a href="<?=site_url('administrador/admin/role') ?>" class="btn btn-default"> Batal</a>
				    	<?php endif ?>
						</form>
					</div>
				</div>
				
				<div class="card mb-4">
					<div class="card-body">
						
						<div class="table-responsive">
							<table class="table" id="dataTable-Role">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Role</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							</table>
						</div>
						<div class="card-footer">
							<mark>Note: </mark>
							<small class="text-danger">Data Role jika didelete maka data usersnya yang lain akan terhapus.</small>
						</div>
					</div>
			</div>
		</div>
  </div>
</div>
  <!-- /.container-fluid -->


	<!-- Page level plugins -->
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.js"></script>
 	<script>
  	// global variable
		var manageRoleTable;

		$(document).ready(function() {
			manageRoleTable = $("#dataTable-Role").DataTable({
				"ajax": '<?php echo site_url('administrador/role/index')  ?>',
				'orders': []
			});	
		});
	</script>


      