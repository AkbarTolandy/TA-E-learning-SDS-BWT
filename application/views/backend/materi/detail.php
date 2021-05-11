	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
	<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Begin Page Content -->
  <div class="container-fluid">

  	<?php $link = site_url('administrador/materi') ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><a href="<?=$link ?>" class="btn btn-primary btn-sm">
    	<i class="fas fa-arrow-left"></i></a> <?=$title ?>
    </h1>
		
		<div class="row  mb-4">
			<div class="col-sm-12 mb-3">
				<div class="card shadow">
					<?php if($this->session->userdata('role_id') == 3) {
            $table = 'siswa';
          } else if($this->session->userdata('role_id') == 2) {
            $table = 'guru';
          } else {
              $table = 'administrator';
          } ?>
          <!-- Card Header - Accordion -->
          <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse">
            <h5 class="m-0 font-weight-bold text-primary"></h5>
            <?php $u = $this->db->get_where($table, array('user_id' => $user['id']))->row_array(); ?>
            <p>Pembuatan Materi : <mark><?= $u['name'] ?></mark> - <?= $u['number_phone'] ?></p>
          </a>
          <!-- Card Content - Collapse -->
          <div class="collapse show" id="collapseCardExample">
            <div class="card-body">

            	<div class="row">
            		<div class="col-sm-3">
            			<a href="" class="btn btn-sm btn-outline-primary">
            			<i class="fa fa-file-download"></i> Download Disini</a>
				        	<div class="p-3">
				        		<p class="mb-0">Materi Online Sudah Aktif? </p>
			            	<div class="custom-control custom-radio custom-control-inline">
										  <input type="radio" id="yes" name="is_publish" class="custom-control-input" <?=$course->is_publish ? 'checked' : '' ?>>
										  <label class="custom-control-label" for="yes">Yes</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
										  <input type="radio" id="no" name="is_publish" class="custom-control-input" <?=$course->is_publish ? 'checked' : '' ?>>
										  <label class="custom-control-label" for="no">No</label>
										</div>
				        	</div>
            		</div>
							 	
							  <div class="col-sm">
							  	<h5 class="mt-0"><mark>Materi</mark></h5>
							    <p><?=$course->title ?></p>

							    <h5 class="mt-0"><mark>Deskripsi Singkat.</mark></h5>
							    <p><?=$course->description ?></p>
									
									<ul class="list-group list-group-flush">
									  <li class="list-group-item">Tanggal Dibuat: <br> <?=$course->created_at ?></li>
									  <li class="list-group-item">Prasyarat <br> <?=$course->precondition ?></li>
									</ul>
									
							  </div>
							</div>

            </div>
          </div>
        </div>
			</div>

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header"><h5 class="mt-3"><mark>Tugas Siswa.</mark></h5></div>
					<div class="card-body">
					<div class="table-responsive">
						<table class="table table-condensend" id="table-tugas">
							<thead>
								<th>No</th>
								<th>Nama</th>
								<th>Tanggal Hadir</th>
								<th>Tugas</th>
								<th>Action</th>
							</thead>
							<tbody>
								
								
							</tbody>
						</table>
					</div>
					</div> 
				</div>
			</div>
			
			<!-- <div class="col-sm-7 mb-3">
				<div class="card">


					<div class="card-header">
						<h5 class="font-weight-bold mb-0">Info Pembayaran (<small></small>)</h5>
						<p>Daftar Pembayaran Semua Murid </p>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-condensend">
								<thead>
									<th>No</th>
									<th>Nama</th>
									<th>Tanggal Bayar</th>
									<th>Status</th>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-5 mb-3">
				<div class="card">

					<div class="card-header">
						<h5 class="font-weight-bold mb-0">Daftar Murid (<small></small>)</h5>
						<p>Yang Ikut Kelas Ini</p>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-condensend">
								<thead>
									<th>Nama Murid</th>
									<th>Tanggal Daftar</th>
									
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12">
				<div class="card">

					<div class="card-header">
						<h5 class="font-weight-bold mb-0">Pembayaran Fee </h5>
						<p>Bonus Sebagai Pengajar</p>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-condensend">
								<thead>
									<th>No</th>
									<th>Sesi</th>
									<th>Bonus Mengajar</th>
									<th>Tanggal Transfer</th>
									<th>Status</th>
								</thead>

							</table>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
	<script>
		$(document).ready(function() {
		  $('.image-link').magnificPopup({
		  	type:'image',
		  	zoom: {
			    enabled: true, // By default it's false, so don't forget to enable it

			    duration: 300, // duration of the effect, in milliseconds
			    easing: 'ease-in-out', // CSS transition easing function
			  }
		  });
		});
	</script>
	<!-- Page level plugins -->
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
  	// global variable
		var manageTugasTable

		$(document).ready(function() {
			manageTugasTable = $("#table-tugas").DataTable({
				"ajax": '<?php echo site_url('administrador/materi/getTugasOnline/'.$course->id)  ?>',
				'orders': [],
				"ordering": false
			});	
		});
  </script>