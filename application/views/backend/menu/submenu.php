
	<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
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
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#ModalSubMenu" onclick="addSubmenuModel()">Add Sub Menu</a>
          </div>
          <div class="card-body">
          	<div class="table-responsive">
          		<table class="table " id="dataTable-submenu">
							  <thead>
							    <tr>
							      <th scope="col">No</th>
							      <th scope="col">Title</th>
							      <th scope="col">Menu</th>
							      <th scope="col">Url</th>
							      <th scope="col">Icon</th>
							      <th scope="col">Active</th>
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

	<!-- Modal -->
	<div class="modal fade" id="ModalSubMenu">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Sub Menu</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <form action="<?=site_url('administrador/menu/store') ?>" method="POST" id="formSubmenu">
	      <div class="modal-body">
	        <div class="form-group">
	        	<label for="title">Title</label>
	        	<input type="text" placeholder="Title" id="title" name="title" class="form-control">
	        </div>
	        <div class="row">
	        	<div class="col-sm">
	        		<div class="form-group">
			        	<label for="menu_id">Menu</label>
			        	<select name="menu_id" class="form-control" id="menu_id">
			        		<option value="">Select Menu</option>
			        		<?php foreach($menus as $menu) : ?>
			        		<option value="<?=$menu['id'] ?>"><?=$menu['menu'] ?></option>
			        		<?php endforeach ?>
			        	</select>
			        </div>
	        
	        	</div>
	        	<div class="col-sm">
	        		<div class="form-group">
			        	<label for="icon">Icon</label>
			        	<input type="text" placeholder="Icon" id="icon" name="icon" class="form-control">
			        </div>
	        	</div>
	        </div>
	        <div class="form-group">
	        	<label for="url">URL</label>
	        	<input type="text" placeholder="Base Url" id="url" name="url" class="form-control">
	        </div>
	        <div class="form-group">
						<div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" value="1" id="is_active" name="is_active" checked>
						  <label class="custom-control-label" for="is_active">Check this Active?</label>
						</div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button class="btn btn-primary" type="submit">Save changes</button>
	      </div>
      </form>
    </div>
  </div>
	</div>

	<!-- Page level plugins -->
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
  	// global variable
		var manageSubmenuTable;

		$(document).ready(function() {
			manageSubmenuTable = $("#dataTable-submenu").DataTable({
				"ajax": '<?php echo site_url('administrador/menu/getSubmenu')  ?>',
				'orders': []
			});	
		});

		function addSubmenuModel() 
		{
			$("#formSubmenu")[0].reset();
			$('.modal-title').text('Add Sub Menu');
			$('#formSubmenu').attr('action', '<?php echo site_url('administrador/menu/store')  ?>')

			//remove textdanger
			$(".text-danger").remove();
			// remove form-group
			$(".form-control").removeClass('has-error').removeClass('has-success');

			$("#formSubmenu").unbind('submit').bind('submit', function() {
				var form = $(this);

				// remove the text-danger
				$(".text-danger").remove();

				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(), // /converting the form data into array and sending it to server
					dataType: 'json',
					success:function(response) {
						if(response.success === true) {
							$(".messages").html('<div class="alert alert-success alert-dismissible">'+
							  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
							'</div>');

							// hide the modal
							$("#ModalSubMenu").modal('hide');
							manageSubmenuTable.ajax.reload(null, false); 
						} else {
							if(response.messages instanceof Object) {
								$.each(response.messages, function(index, value) {
									var id = $("#"+index);

									id
									.removeClass('has-error')
									.removeClass('has-success')
									.addClass(value.length > 0 ? 'has-error' : 'has-success')

									id
									.closest('.form-group')
									.append(value);
								});
							} else {
								$(".messages").html('<div class="alert alert-warning alert-dismissible">'+
								  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
								  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
								'</div>');
							}
						}
					}
				});	

				return false;
			});

		}

		function editSubmenu(id = null) 
		{
			if(id) {

				$("#formSubmenu")[0].reset();
				$('.form-control').removeClass('has-error').removeClass('has-success');
				$('.text-danger').remove();
				$('.modal-title').text('Edit Sub Menu');
				$('#formSubmenu').attr('action', '<?php echo site_url('administrador/menu/update/')  ?>' +id)

				$.ajax({
					url: '<?php echo site_url('administrador/menu/getSelectedSubMenuInfo/')  ?>' +id,
					type: 'POST',
					dataType: 'json',
					success:function(response) {
						$("#title").val(response.title);
						$("#menu_id").val(response.menu_id);
						$("#url").val(response.url);
						$("#icon").val(response.icon);

						$("#formSubmenu").unbind('submit').bind('submit', function() {
							var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: 'POST',
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success === true) {
										$(".messages").html('<div class="alert alert-success alert-dismissible">'+
										  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
										  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
										'</div>');

										// hide the modal
										$("#ModalSubMenu").modal('hide');
										manageSubmenuTable.ajax.reload(null, false); 

									} else {
										$('.text-danger').remove()

										if(response.messages instanceof Object) {
											$.each(response.messages, function(index, value) {
												var id = $("#"+index);

												id
												.removeClass('has-error')
												.removeClass('has-success')
												.addClass(value.length > 0 ? 'has-error' : 'has-success')

												id
												.closest('.form-group')
												.append(value);									

											});
										} else {
											$(".messages").html('<div class="alert alert-warning alert-dismissible">'+
											  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
											  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
											'</div>');
										}
									}
								} // /succes
							}); // /ajax

							return false;
						});
						
					}
				});

			} else {
				alert('error failed');
			}
		}

		function removeSubmenu(id = null) 
		{
			if(confirm('Are you sure delete this data?')) {
		    // ajax delete data to database
		    $.ajax({
		      url : '<?php echo site_url('administrador/menu/remove/')  ?>'+id,
		      type: "POST",
		      dataType: "JSON",
		      success: function(response) {
		        if(response.success === true) {
							

							manageSubmenuTable.ajax.reload(null, false); 
							$(".messages").html('<div class="alert alert-success alert-dismissible">'+
							  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
							'</div>');
						}
		      },
		      error: function (jqXHR, textStatus, errorThrown) {
		        alert('Error deleting data');
		      }
		    });
		  } else {
		  	return false
		  }
		}
  </script>



      