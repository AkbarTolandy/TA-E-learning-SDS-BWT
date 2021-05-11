
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
            <h5 class="m-0 font-weight-bold text-primary">Tambah Category Menu</h5>
            <small>Silahkan masukkan data menu untuk setiap halaman websitenya.</small>
          </div>
        	<?php endif ?>
					<div class="card-body">

						<?php
						if($this->uri->segment(3) == 'edit') :
			        $url = site_url('administrador/category-menu/edit/'.$category->id);
			      else:
			        $url = site_url('administrador/category-menu');
			      endif ?>

						<form action="<?=$url ?>" method="POST">
				    
				    	<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
						    		<input type="text" class="form-control" name="sort" id="sort" placeholder="Urutan"
						    			value="<?=($this->uri->segment(3) == 'edit') ? $category->sort : set_value('sort') ?>">
						    		<?=form_error('sort', '<small class="text-danger">', '</small>') ?>
						    	</div>
								</div>
								<div class="col">
									<div class="form-group">
						    		<input type="text" class="form-control" name="name" id="name" placeholder="Nama" 
						    			value="<?=($this->uri->segment(3) == 'edit') ? $category->menu : set_value('name') ?>">
						      	<?=form_error('name', '<small class="text-danger">', '</small>') ?>
						    	</div>
								</div>
							</div>
							
				    	<div class="form-group">
				    		<label for="link_url" class="font-weight-bold">Link URL </label>
				    		<input type="text" class="form-control" name="link_url" id="link_url" placeholder="http://" 
				    			value="<?=($this->uri->segment(3) == 'edit') ? $category->link_url : set_value('link_url') ?>">
					    	<?=form_error('link_url', '<small class="text-danger">', '</small>') ?>
				    	</div>

						  <div class="form-group">
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" <?=($this->uri->segment(3) == 'edit' && $category->active) ? 'checked' : '' ?> value="1" id="is_active" name="is_active" <?php echo set_checkbox('is_active', '1') ?>>
								  <label class="custom-control-label" for="is_active">Menu Akan DiTampilkan?</label>
								</div>
				    	</div>
				      
				      <button class="btn btn-primary" type="submit">Simpan Data</button>
				      <?php if($this->uri->segment(3) == 'edit') : ?>
				      <a href="<?=site_url('administrador/category-menu') ?>" class="btn btn-default"> Batal</a>
				    	<?php endif ?>
						</form>
					</div>
				</div>
				
				<div class="card mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable-category">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Nama</th>
							      <th scope="col">Link URL</th>
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
		var manageCategoryTable;

		$(document).ready(function() {
			manageCategoryTable = $("#dataTable-category").DataTable({
				"ajax": '<?php echo site_url('administrador/category-menu/getCategory')  ?>',
				'orders': []
			});	
		})
	</script>


      