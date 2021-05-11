
<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
    <p class="mb-4">Mulai Pembelajaran</p>

		<div class="row">
			<div class="col-sm-7">
				<?=$this->session->flashdata('message') ?>

				<div class="card mb-4">
					<div class="card-body">

						<?php
						if($this->uri->segment(3) == 'edit') :
			        $url = site_url('administrador/tahun-studi/edit/'.$tahun_ajaran->id);
			      else:
			        $url = site_url('administrador/tahun-studi');
			      endif ?>

						<form action="<?=$url ?>" method="POST">
							<div class="form-group">
				    		<input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" placeholder="Tahun" value="<?=($this->uri->segment(3) == 'edit') ? $tahun_ajaran->year : set_value('tahun_ajaran') ?>">
				      	<?=form_error('tahun_ajaran', '<small class="text-danger">', '</small>') ?>
				    	</div>
				      
				      <button class="btn btn-primary" type="submit">Simpan Data</button>
				      <?php if($this->uri->segment(3) == 'edit') : ?>
				      <a href="<?=site_url('administrador/tahun-studi') ?>" class="btn btn-default"> Batal</a>
				    	<?php endif ?>
						</form>
					</div>
				</div>
				
				<div class="card mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable-tahunstudi">
							  <thead>
							    <tr>
							      <th scope="col">No</th>
							      <th scope="col">Tahun Ajaran</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  </tbody>
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
		var managetahunstudiTable;

		$(document).ready(function() {
			managetahunstudiTable = $("#dataTable-tahunstudi").DataTable({
				"ajax": '<?php echo site_url('administrador/tahun-studi/gettahunstudi')  ?>',
				'orders': [],
				"ordering": false
			});	
		});
	</script>


      