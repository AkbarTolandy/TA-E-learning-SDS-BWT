
	<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    </div>

		<div class="row">
			<div class="col-sm-12">
				<?php if(validation_errors()) : ?>
					<div class="alert alert-danger">
						<?=validation_errors() ?>
					</div>
				<?php endif ?>

				<div class="messages"></div>
				<?=$this->session->flashdata('message') ?>
				
				<div class="card mb-4">
					<div class="card-header py-3">
            <a href="<?=site_url('administrador/guru/cetak-laporan') ?>" class="btn btn-primary">Cetak Data Guru</a>
          </div>
          <div class="card-body">
          	<div class="table-responsive">
          		<table class="table" id="dataTable-guru">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col"></th>
							      <th>Photo</th>
							      <th scope="col">Nama</th>
							      <th scope="col">Tanggal Daftar</th>

							      <th scope="col">Status</th>
							      <th scope="col"></th>
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
		var manageGuruTable;

		$(document).ready(function() {
			manageGuruTable = $("#dataTable-guru").DataTable({
				"ajax": '<?php echo site_url('administrador/guru/getLaporanGuru')  ?>',
				'orders': [],
				'ordering': false
			});	
		});

		$('body').on('click', '.delete_checkbox', function(){
			if($(this).is(':checked')) {
				$(this).closest('tr').addClass('table-warning');
			} else {
				$(this).closest('tr').removeClass('table-warning');
			}
		});

  </script>