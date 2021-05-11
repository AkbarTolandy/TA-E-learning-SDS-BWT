
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
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kelas Baru</h6>
          </div>
        	<?php endif ?>
					<div class="card-body">

						<?php
						if($this->uri->segment(3) == 'edit') :
			        $url = site_url('administrador/kelas/edit/'.$kelas->id);
			      else:
			        $url = site_url('administrador/kelas');
			      endif ?>

						<form action="<?=$url ?>" method="POST">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
						    		<input type="text" class="form-control" 
						    			name="kode_kelas" id="kode_kelas" placeholder="Nomor" 
						    			value="<?=($this->uri->segment(3) == 'edit') ? $kelas->kode_kelas : set_value('kode_kelas') ?>">
						      	<?=form_error('kode_kelas', '<small class="text-danger">', '</small>') ?>
						    	</div>
								</div>
								<div class="col">
									<div class="form-group">
						    		<input type="text" class="form-control" name="name" id="menu" placeholder="Nama Kelas" 
						    			value="<?=($this->uri->segment(3) == 'edit') ? $kelas->nama_kelas : set_value('name') ?>">
						      	<?=form_error('name', '<small class="text-danger">', '</small>') ?>
						    	</div>
								</div>
							</div>
				      
				      <button class="btn btn-primary" type="submit">Simpan Data</button>
				      <?php if($this->uri->segment(3) == 'edit') : ?>
				      <a href="<?=site_url('administrador/kelas') ?>" class="btn btn-default"> Batal</a>
				    	<?php endif ?>
						</form>
					</div>
				</div>
				
				<div class="card mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable-kelas">
							  <thead>
							    <tr>
							      <th scope="col">No</th>
							      <th scope="col">Kode Kelas</th>
							      <th scope="col">Kelas</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  </tbody>
							</table>
						</div>
						<div class="card-footer">
							<mark>Note: </mark>
							<small class="text-danger">Data kelas jika didelete 
							maka info kelas siswa akan dinonaktifkan.</small>
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
		var manageKelasTable;

		$(document).ready(function() {
			manageKelasTable = $("#dataTable-kelas").DataTable({
				"ajax": '<?php echo site_url('administrador/kelas/getkelas')  ?>',
				'orders': [],
				"ordering": false
			});	
		});
	</script>


      