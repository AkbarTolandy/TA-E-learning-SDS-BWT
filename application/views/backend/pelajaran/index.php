
	<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
		<div class="row">
			<div class="col-sm-7">
				<?=$this->session->flashdata('message') ?>

				<div class="card mb-4">
					<?php if($this->uri->segment(3) !== 'edit') : ?>
					<div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Pelajaran : </h6> 
            <small>berdasarkan kurikulum</small>
          </div>
        	<?php endif ?>
					<div class="card-body">

						<?php
						if($this->uri->segment(3) == 'edit') :
			        $url = site_url('administrador/pelajaran/edit/'.$materi->id);
			      else:
			        $url = site_url('administrador/pelajaran');
			      endif ?>

						<form action="<?=$url ?>" method="POST">
				    	<div class="form-group">
				    		<input type="text" class="form-control" name="name" id="name" placeholder="Nama" 
				    			value="<?=($this->uri->segment(3) == 'edit') ? $materi->nama_pelajaran : set_value('name') ?>">
				      	<?=form_error('name', '<small class="text-danger">', '</small>') ?>
				    	</div>

				    	<div class="form-group">
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" value="1" 
								  <?=($this->uri->segment(3) == 'edit' && $materi->status == 1) ? 'checked' : '' ?> id="status" name="status">
								  <label class="custom-control-label" for="status">Pelajaran Ingin Dipublish?</label>
								</div>
					    </div>
				      
				      <button class="btn btn-primary" type="submit">Simpan Data</button>
				      <?php if($this->uri->segment(3) == 'edit') : ?>
				      <a href="<?=site_url('administrador/pelajaran') ?>" class="btn btn-default"> Batal</a>
				    	<?php endif ?>
						</form>
					</div>
				</div>
				
				<div class="card mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable-pelajaran">
							  <thead>
							    <tr>
							      <th scope="col">No</th>
							      <th scope="col">Nama</th>
							      <th scope="col">Slug</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							</table>
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
		var managePelajaranTable;

		$(document).ready(function() {
			managePelajaranTable = $("#dataTable-pelajaran").DataTable({
				"ajax": '<?php echo site_url('administrador/pelajaran/getMataPelajaran')  ?>',
				'orders': [],
				"ordering": false
			});	
		})
	</script>


      