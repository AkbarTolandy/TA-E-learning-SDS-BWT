
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
				
				<div class="card mb-7">
					<div class="card-header py-3">
            <a href="<?=site_url('administrador/guru/store') ?>" class="btn btn-primary">Tambah Guru</a>
          </div>
          <div class="card-body">
          	<div class="table-responsive">
          		<table class="table" id="dataTable-guru">
							  <thead>
							    <tr>
							      <th scope="col">No</th>
							      <th scope="col">Pilih</th>
							      <th>Photo</th>
							      <th scope="col">Nama</th>
							      <th scope="col">Tanggal Daftar</th>

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

  <div class="modal fade" id="guru-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="guru-title">Detail Guru</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="guru-body"> 
      </div>
      <div class="modal-footer"></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<!-- Page level plugins -->
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
  	// global variable
		var manageGuruTable;

		$(document).ready(function() {
			manageGuruTable = $("#dataTable-guru").DataTable({
				"ajax": '<?php echo site_url('administrador/guru/getGuru')  ?>',
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