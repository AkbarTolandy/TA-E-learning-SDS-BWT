
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
            <a href="<?=site_url('administrador/siswa/create') ?>" class="btn btn-primary">Tambah Murid</a>
          </div>
          <div class="card-body">
          	<div class="table-responsive">
          		<table class="table" id="dataTable-siswa">
							  <thead>
							    <tr>
							      <th scope="col" width="10">No</th>
							      <th scope="col" width="10">Checklist</th>
							      <th width="50">Photo</th>
							      <th width="150">Nama</th>
							      
							      <th scope="col">Tanggal Daftar</th>

							      <th scope="col">Status</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							</table>
          	</div>
          	<div class="card-footer">
							<mark>Note: </mark>
							<small class="text-danger">Data Murid jika didelete maka data kelas yg pernah di lakukan akan terhapus.</small>
						</div>
          </div>
				</div>
			</div>
		</div>
  </div>
  <!-- /.container-fluid -->

  <div class="modal fade" id="siswa-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="siswa-title">Detail Murid</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="siswa-body"> 
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
		var manageSiswaTable;

		$(document).ready(function() {
			manageSiswaTable = $("#dataTable-siswa").DataTable({
				"ajax": '<?php echo site_url('administrador/siswa/getSiswa')  ?>',
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