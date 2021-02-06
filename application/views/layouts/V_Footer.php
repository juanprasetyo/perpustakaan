  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
          <h5>Title</h5>
          <p>Sidebar content</p>
      </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
          Anything you want
      </div>
      <!-- Default to the left -->
      <strong><?= date('Y') ?></strong> All rights reserved.
  </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Sweet Alert 2 -->
  <script src="<?= base_url('assets/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?= base_url('assets/') ?>plugins/toastr/toastr.min.js"></script>
  <!-- iCheck -->
  <script src="<?= base_url('assets/') ?>plugins/icheck/icheck.min.js"></script>
  <!-- Lozad -->
  <script src="<?= base_url('assets/') ?>plugins/lozad/lozad.min.js"></script>
  <!-- Bs Custom file Input -->
  <script src="<?= base_url('assets/') ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- Progressive Image -->
  <script src="<?= base_url('assets/') ?>plugins/progressive-image/progressive-image.js"></script>
  <!-- Chart js -->
  <script src="<?= base_url('assets/') ?>plugins/chart.js/chart.min.js"></script>
  <!-- Ekko lightbox -->
  <script src="<?= base_url('assets/') ?>plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
  <!-- Parsley -->
  <script src="<?= base_url('assets/') ?>plugins/parsley/parsley.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/') ?>js/adminlte.min.js"></script>
  <script>
const baseurl = "<?= base_url() ?>";

// Lozad
const observer = lozad();
observer.observe();

// Ekko lightbox
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

$(document).ready(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    $('.nav-sidebar').on('click', '.nav-single', function() {
        $('.nav-item').find('a').removeClass('active');
        $(this).children('a').addClass('active');
        if ($('.nav-treeview').find('a').hasClass('active')) {
            $('.nav-treeview .active').parent('.nav-item').parent('.nav-treeview').parent('.nav-item').children('a').addClass('active');
        }
    });

    // Custom Input file
    $(function() {
        bsCustomFileInput.init();
    });

    // preview Image
    function readUrl(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-image').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0])
        }
    }
    $('#inputImage').change(function(e) {
        readUrl(this);
    })
})
  </script>

  <?php 
        // Alert login
        if($this->session->flashdata('login')){
            $login = $this->session->flashdata('login');
            echo "
                <script>
                Toast.fire({
                    icon: '". $login['type'] ."',
                    title: '". $login['message'] ."'
                  })
                </script>
                ";
        }

        // Alert Notification with button
        if($this->session->flashdata('alert-notif')){
            $data = $this->session->flashdata('alert-notif');
                echo "
                        <script>
                        Swal.fire({
                            icon: '". $data['type'] ."',
                            title: '". $data['title'] ."',
                            text: '".$data['text']."',
                            footer: '".$data['footer']."'
                          })
                        </script>
                     ";
        }
    ?>
  <!-- Custom js -->
  <script src="<?= base_url('assets/js/pages/customBook.js?version='. filemtime('assets/js/pages/customBook.js')) ?>"></script>
  <script src="<?= base_url('assets/') ?>js/pages/customProfile.js"></script>
  </body>

  </html>