<div class="container justify-content-center">
  <!-- https://colorlib.com/preview/#poportfolio
http://demo.themefisher.com/thomson/index.html -->
  <div class="col-lg-6 mx-auto">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="text-center mb-4">
                <h1 class="h4 text-gray-900">Daftar <strong class="text-primary">Sekarang!</strong></h1>
                <a href="<?=site_url('home') ?>">Kembali Ke Home</a>
              </div>
              <form class="user" method="POST" action="<?=site_url('register') ?>">
                <div class="form-group">
                  <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nama Lengkap" value="<?=set_value('fullname') ?>">
                  <?=form_error('fullname', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="number_phone" name="number_phone" placeholder="Nomor Telepon/Nomor WhatsApp" value="<?=set_value('number_phone') ?>">
                  <?=form_error('number_phone', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?=set_value('email') ?>"><small>(kode verifikasi akan dikirim kesana)</small> <br>
                  <?=form_error('email', '<span class="text-danger">', '</span>') ?> 
                  
                </div>

                <!-- <div class="form-group">
                  <label for="">Darimana kamu mengetahui program ini? *</label>
                  <input type="text" name="info_program" 
                  class="form-control" placeholder="Facebook/Instagram/Google/Website/Teman">
                </div> -->

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                    <?=form_error('password1', '<span class="text-danger">', '</span>') ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Ulangi Password">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  Daftar Gratis
                </button>
                <p class="mt-3"><code>*</code> Dengan menekan tombol daftar, kamu setuju dengan ketentuan dan syarat yang berlaku</p>
              </form>
              <hr>
              <div class="text-center">
                <a href="<?=site_url('forgot-password') ?>">Lupa password?</a>
              </div>
              <div class="text-center">
                <a href="<?=site_url('login') ?>">*Sudah punya akun? login disini?</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>