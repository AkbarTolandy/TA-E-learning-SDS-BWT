

<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-lg-6">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900">Change <strong class="text-primary">Password</strong></h1>
                  <h5 class="mb-4"><?=$this->session->userdata('reset_email') ?></h5>
                </div>
                
                <?=$this->session->flashdata('message') ?>

                <form class="user" method="POST" action="<?=site_url('administrador/auth/change-password') ?>">
                  <div class="form-group">
                    <input type="hidden" name="email" class="form-control form-control-user" value="<?=$this->session->userdata('reset_email') ?>">
                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter new password">
                    <?=form_error('password1', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                    <?=form_error('password2', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Change Password
                  </button>
                </form>
                <hr>
                <!-- <div class="text-center">
                  <a class="small" href="<?=site_url('administrador') ?>">Back to login</a>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>


