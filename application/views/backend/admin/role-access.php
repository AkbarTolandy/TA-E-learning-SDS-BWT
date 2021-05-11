

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
		<div class="row">
			<div class="col-sm-4">
				<?=$this->session->flashdata('message') ?>

				<div class="card mb-4">
					<div class="card-header py-3">
						<h6 class="mb-0">Role: <mark><?=$role['role_name'] ?></mark></h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Menu</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							  <tbody>
							  	<?php $i = 1; foreach($menus as $menu) : ?>
							    <tr>
							      <th scope="row"><?=$i ?></th>
							      <td><?=$menu['menu'] ?></td>
							      <td>
							      	<div class="custom-control custom-checkbox small">
	                      <input type="checkbox" class="form-check-input custom-control-input" id="check-input-<?=$menu['id'] ?>" data-role="<?=$role['id'] ?>" data-menu="<?=$menu['id'] ?>" type="checkbox" <?=check_access($role['id'], $menu['id']) ?>>
	                      <label class="custom-control-label" for="check-input-<?=$menu['id'] ?>"></label>
                    	</div>
							      	
							      </td>
							    </tr>
							  	<?php $i++; endforeach ?>
							  </tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<a href="<?=site_url('administrador/admin/role') ?>" class="btn btn-sm btn-secondary"> Kembali</a>
					</div>
				</div>


			</div>
		</div>
  </div>
  <!-- /.container-fluid -->


      