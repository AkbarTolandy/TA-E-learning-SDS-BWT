

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <?=$this->session->flashdata('message') ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
    <?php if($this->session->userdata('role_id') == 3) {
      $data = $this->db->get_where('siswa', ['user_id' => $user['id']])->row_array(); 
    } else if($this->session->userdata('role_id') == 2) {
      $data = $this->db->get_where('guru', ['user_id' => $user['id']])->row_array();  
    } else { 
      $data = $this->db->get_where('administrator', ['user_id' => $user['id']])->row_array(); 
    } ?>
    <div class="row mb-3">
      <div class="col-sm-4 mb-3">
        <div class="card shadow h-100 py-2">
          <div class="card-body">
            <div class="row">
              <div class="col mr-2">
                <img src="<?=base_url() ?>assets/backend/img/profile/<?=$data['avatar'] ?>" width="100" class="img-thumbnail mb-3">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?=$data['name'] ?></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$user['username'] ?></div>
                <p class="card-text"><small class="text-muted">Daftar Sejak <?=date('d F Y', strtotime($user['created_at'])) ?></small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <?php if($this->session->userdata('role_id') == 3) { ?>
          <div class="list-group">
            <li href="#" class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-0 font-weight-bold">Nomor Telepon</h5>
              </div>
              <p class="mb-1"><?=$data['number_phone'] ?></p>
              <hr>
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-0 font-weight-bold">Jenis Kelamin</h5>
              </div>
              <p class="mb-1"><?=$data['gender'] == 'L' ? 'Laki Laki' : 'Perempuan' ?></p>
              <hr>
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-0 font-weight-bold">Alamat</h5>
              </div>
              <p class="mb-1"><?=$data['address'] ?></p>
            </li>
          </div>
          <?php } else if($this->session->userdata('role_id') == 2) { ?>
          <div class="list-group">
            <li href="#" class="list-group-item">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-0 font-weight-bold">Nomor Telepon</h5>
              </div>
              <p class="mb-1"><?=$data['number_phone'] ?></p>
              <hr>
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-0 font-weight-bold">Jenis Kelamin</h5>
              </div>
              <p class="mb-1"><?=$data['gender'] == 'L' ? 'Laki Laki' : 'Perempuan' ?></p>
            </li>
          </div>
          <?php } else { ?>
            <div class="card-body">
              <p>tidak memiliki detail profile.</p>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    

  </div>
  <!-- /.container-fluid -->


      