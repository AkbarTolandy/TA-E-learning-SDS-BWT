
	<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    <p class="mb-4">Bersama dan Berdiskusi dengan banyak teman.</p>
		<div class="row">
			<div class="col-sm">
				<?php if(validation_errors()) : ?>
					<div class="alert alert-danger">
						<?=validation_errors() ?>
					</div>
				<?php endif ?>

				<div class="messages"></div>
				<?=$this->session->flashdata('message') ?>
				
				<div class="card mb-4">
					<div class="card-header py-3">
            <a href="<?=site_url('administrador/materi/store') ?>" class="btn btn-primary">Tambah Materi</a>
          </div>
          <div class="card-body">
          	<div class="table-responsive">
          		<table class="table" id="dataTable-materi">
							  <thead>
							    <tr>
							      <th scope="col" width="10">No</th>
							      <th scope="col">Pertemuan</th>
							      <th scope="col">Nama Materi</th>							      
							      <th scope="col">Tanggal Publish</th>
							      <th scope="col">Status</th>
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
		var manageMateriTable

		$(document).ready(function() {
			manageMateriTable = $("#dataTable-materi").DataTable({
				"ajax": '<?php echo site_url('administrador/materi/getMateriOnline')  ?>',
				'orders': [],
				"ordering": false
			});	
		});
  </script>



      