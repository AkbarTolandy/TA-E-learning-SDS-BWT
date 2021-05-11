<div class="container-login mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card my-5">
        <div class="card-body">
         <div class="text-center">
          <h1 class="h4 text-gray mb-4 font-italic">E-Learning SDS Barunawati IV</h1>
        </div>

          <?=$this->session->flashdata('message') ?>
          <form method="POST" action="<?=site_url('login') ?>">
            <div class="form-group">
              <label for="username" class="font-weight-bold">Username</label>
              <input name="username" class="form-control" placeholder="ex. username login" value="<?=set_value('username') ?>" type="text">
              <?=form_error('username', '<span class="text-danger">', '</span>') ?>
            </div> <!-- form-group// -->

            <div class="form-group">
              <a class="float-right" href="#">Forgot</a>
              <label for="password" class="font-weight-bold">Password</label>
              <input class="form-control" name="password" placeholder="******" type="password">
              <?=form_error('password', '<span class="text-danger">', '</span>') ?>
            </div> <!-- form-group// --> 

            <div class="form-group"> 
              <label class="custom-control custom-checkbox"> 
                <input type="checkbox" name="remember_me" class="custom-control-input"> 
                <div class="custom-control-label"> Remember Me </div> 
              </label>
            </div> <!-- form-group form-check .// -->

            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block"> Login  </button>
            </div> <!-- form-group// -->   

          </form>
        </div> <!-- card-body.// -->
        <!-- <div class="card-footer text-center">Don't have an account? 
        <a href="">Sign up</a></div> -->
      </div>
    </div>
  </div>
</div>


