
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" />
<script src="<?=base_url('assets/') ?>backend/plugin/ckeditor/ckeditor.js"></script>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
  <p class="mb-4">Edit materi berdasarkan pelajaran</p>
  <form action="<?=site_url('administrador/materi/edit/' .$materi->id) ?>" method="POST" 
  	enctype="multipart/form-data">
		<div class="row">
			<div class="col-sm-9">
				<div class="card mb-4 shadow">
				  <div class="card-body">
				  	<div class="row">
				  		<div class="col-sm">
					    	<div class="form-group">
						    	<label for="bab" class="text-primary">Bab</label>
						    	<input type="text" placeholder="Pertemuan" id="bab" name="bab" class="form-control" value="<?=$materi->bab ?>">				 
						    	<?=form_error('bab', '<small class="text-danger">', '</small>') ?>
					    	</div>
					    </div>
					    <div class="col-sm-9">
					    	<div class="form-group">
						    	<label for="title" class="text-primary">Nama Materi</label>
						    	<input type="text" placeholder="Judul" id="title" name="title" class="form-control" value="<?=$materi->title ?>">				 
						    	<?=form_error('title', '<small class="text-danger">', '</small>') ?>
						    </div>
					    </div>
				  	</div>

				    <div class="form-group">
				    	<label for="slug" class="text-primary">Slug</label>
				    	<input type="text" readonly id="slug" name="slug" class="form-control" value="<?=$materi->slug ?>">
				    </div>

		    		<div class="form-group">
				    	<label for="precondition" class="text-primary">Prasyarat <?=form_error('precondition', '<small class="text-danger">', '</small>') ?></label>
				    	<textarea style="resize: none" name="precondition" cols="50" rows="3" id="precondition" class="form-control"><?=$materi->precondition ?></textarea>
				    	<div class="form-text text-muted"><small>Maximal 160 Karakter</small></div>
				    </div>

				    <div class="form-group">
				    	<label for="description" class="text-primary">Description <?=form_error('description', '<small class="text-danger">', '</small>') ?></label>
				    	<textarea name="description" cols="50" rows="10" id="description" class="form-control"><?=$materi->description ?></textarea>
				    </div>
		
				  </div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="card mb-4 shadow">
					<div class="card-body">
						<div class="form-group">
		        	<label for="pelajaran_id" class="text-primary">Pelajaran </label>
		        	<select name="pelajaran_id" class="form-control" id="pelajaran_id">
		        		<option value="">-- Pilih --</option>
		        		<?php foreach($pelajaran as $pj) : ?>
		        		<option value="<?=$pj['id'] ?>" 
		        			<?= set_select('pelajaran_id', $pj['id'], FALSE) ?> <?=$materi->pelajaran_id == $pj['id'] ? 'selected' : '' ?>><?=$pj['nama_pelajaran'] ?></option>
		        		<?php endforeach ?>
		        	</select>
		        	<?=form_error('pelajaran_id', '<small class="text-danger">', '</small>') ?>
		        </div>
						
					</div>
				</div>

				<div class="card mb-4 shadow">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
	          <h6 class="m-0 text-primary">Dokumen Materi</h6>
	        </div>

					<div class="card-body">
						<input type="file" name="file">
					</div>

					<div class="card-footer <?=$this->session->flashdata('error-upload') ? 'p-1' : 'p-0' ?>">
						<style>
							.alert {border-radius: 0; margin-bottom: 0}
						</style>
						<?=$this->session->flashdata('error-upload') ?>
						<?=form_error('file', '<small class="text-danger ml-3">', '</small>') ?>
					</div>

					<div class="card-footer">
						<div class="form-group">
			        <label for="created_at" class="text-primary">Tanggal Publish</label>
							<input type="text" value="<?=$materi->created_at ?>" class="form-control" id="datepicker" placeholder="YY-MM-DD HH:MM" name="created_at">
			      </div>

						<div class="form-group">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" value="1" id="is_publish" name="is_publish" <?php echo set_checkbox('is_publish', '1') ?> <?=$materi->is_publish ? 'checked' : '' ?>>
							  <label class="custom-control-label" for="is_publish">Materi ingin di publish?</label>
							</div>
				    </div>

				    <a href="<?=site_url('administrador/materi') ?>" class="btn btn-secondary">Batal</a>
				    <button class="btn btn-primary" type="submit">Simpan Materi</button>
			    </div>
				</div>

			</div>
		</div>
	</form>
</div>

<!-- AdminLTE App -->
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script>
<script>
CKEDITOR.replace('description', {
  filebrowserImageBrowseUrl : '<?php echo base_url('assets/backend/plugin/kcfinder/browse.php') ?>'
});
</script>
<script>
  $(document).ready(function() {
    $('#title').blur(function(){
      const title = this.value.toLowerCase().trim(),
        slugInput = $('#slug'),
        slug = title.replace(/&/g, '-and-')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+|-+$/g, '')

        slugInput.val(slug)

    })

    $('#datepicker').datetimepicker({
      uiLibrary: 'bootstrap4',
      format: 'yyyy-mm-dd HH:MM',
      footer: true, 
      modal: true
    });
  })
</script>

