
    </div>

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; RuangSiswa <?=date('Y') ?></span>
        </div>
      </div>
    </footer>
    <!-- Footer -->

  </div>
</div>
<!-- End Page Wrapper -->

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <?php if($this->session->userdata('role_id') == 3) {
            $logout = 'logout';
          } else {
            $logout = 'administrador/auth/logout';
          } ?>
          <a class="btn btn-primary" href="<?=site_url($logout) ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <script src="<?=base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url('assets/backend/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?=base_url('assets/backend/') ?>js/ruang-admin.min.js"></script>
  <script>
    $('.custom-file-input').on('change', function(){
      let fileName = $(this).val().split('\\').pop()
      $(this).next('.custom-file-label').addClass('selected').html(fileName)
    })

    $('.form-check-input').on('click', function(){
      const menuId = $(this).data('menu')
      const roleId = $(this).data('role')

      $.ajax({
        url: "<?=site_url('administrador/admin/change-access') ?>",
        type: 'POST',
        data: {
          menuId: menuId,
          roleId: roleId
        },
        success: function() {
          document.location.href = "<?=site_url('administrador/admin/roleaccess/') ?>" +roleId
        }
      })
    })
  </script>
</body>

</html>
